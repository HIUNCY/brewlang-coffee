<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class CheckoutService
{
    /**
     * Process checkout to create an order and its items in a transaction.
     * 
     * @param array $cartItems Enriched cart items from CartService->getCartDetails()['items']
     * @param array $customerData Array with customer_name, customer_email, table_number
     * @param int $totalAmount Total amount calculated from the cart
     * @return Order
     * @throws Exception
     */
    public function process(array $cartItems, array $customerData, int $totalAmount): Order
    {
        if (empty($cartItems)) {
            throw new Exception("Cannot process an empty cart.");
        }

        $order = DB::transaction(function () use ($cartItems, $customerData, $totalAmount) {
            // Lock the active menus to ensure they aren't deleted/changed concurrently
            $menuIds = collect($cartItems)->pluck('menu.id')->toArray();
            $menus = Menu::whereIn('id', $menuIds)->lockForUpdate()->get()->keyBy('id');

            // Recalculate total to ensure data integrity
            $calculatedTotal = 0;
            foreach ($cartItems as $item) {
                $menu = $menus->get($item['menu']->id);
                if (!$menu || !$menu->is_active) {
                    throw new Exception("Menu item '{$item['menu']->name}' is no longer available.");
                }
                $calculatedTotal += $menu->price * $item['quantity'];
            }

            if ($calculatedTotal !== $totalAmount) {
                throw new Exception("Total amount mismatch.");
            }

            // Create Order
            $order = Order::create([
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => $customerData['customer_name'],
                'customer_email' => $customerData['customer_email'],
                'table_number' => $customerData['table_number'],
                'status' => 'unpaid',
                'total_price' => $calculatedTotal,
            ]);

            // Create Order Items
            $orderItems = [];
            foreach ($cartItems as $item) {
                $orderItems[] = OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['menu']->price, // Snapshot the price at the time of order
                ]);
            }
            $order->setRelation('items', collect($orderItems));

            Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));

            return $order;
        });
    }
}
