<?php

namespace App\Services;

use App\Models\Menu;

class CartService
{
    private string $sessionKey = 'cart';

    /**
     * Get the raw cart array from the session.
     * Format: [menu_id => quantity]
     */
    public function getCart(): array
    {
        return session()->get($this->sessionKey, []);
    }

    /**
     * Add an item to the cart, or increment its quantity if it already exists.
     */
    public function add(int $menuId, int $quantity = 1): void
    {
        $cart = $this->getCart();
        
        if (isset($cart[$menuId])) {
            $cart[$menuId] += $quantity;
        } else {
            $cart[$menuId] = $quantity;
        }
        
        // Prevent negative or zero quantities from getting in via add
        if ($cart[$menuId] <= 0) {
            unset($cart[$menuId]);
        }

        session()->put($this->sessionKey, $cart);
    }

    /**
     * Update the exact quantity of an item in the cart.
     */
    public function update(int $menuId, int $quantity): void
    {
        $cart = $this->getCart();
        
        if ($quantity <= 0) {
            unset($cart[$menuId]);
        } else {
            $cart[$menuId] = $quantity;
        }

        session()->put($this->sessionKey, $cart);
    }

    /**
     * Remove an item from the cart completely.
     */
    public function remove(int $menuId): void
    {
        $cart = $this->getCart();
        unset($cart[$menuId]);
        session()->put($this->sessionKey, $cart);
    }

    /**
     * Clear the entire cart.
     */
    public function clear(): void
    {
        session()->forget($this->sessionKey);
    }

    /**
     * Get enriched cart details including the Menu models and calculated totals.
     */
    public function getCartDetails(): array
    {
        $cart = $this->getCart();
        $menuIds = array_keys($cart);
        
        if (empty($menuIds)) {
            return [
                'items' => [],
                'total_quantity' => 0,
                'total_price' => 0,
            ];
        }

        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');
        
        $items = [];
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($cart as $menuId => $quantity) {
            $menu = $menus->get($menuId);
            
            // If menu was deleted or made inactive since adding to cart, skip it
            if (!$menu || !$menu->is_active) {
                continue;
            }

            $subtotal = $menu->price * $quantity;
            
            $items[] = [
                'menu' => $menu,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
            
            $totalQuantity += $quantity;
            $totalPrice += $subtotal;
        }

        return [
            'items' => $items,
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
        ];
    }
}
