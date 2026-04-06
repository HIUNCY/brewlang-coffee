<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Exception;

class HomeController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private CheckoutService $checkoutService
    ) {}

    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        // optionally filter by category in UI
        $menus = Menu::active()->with('category')->get();
        
        $cartDetails = $this->cartService->getCartDetails();

        return view('public.home', compact('categories', 'menus', 'cartDetails'));
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id,is_active,1',
            'quantity' => 'nullable|integer|min:1|max:100',
        ]);

        $this->cartService->add($validated['menu_id'], $validated['quantity'] ?? 1);

        return redirect()->back()->with('success', 'Item added to cart.');
    }

    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|integer',
            'quantity' => 'required|integer|min:0|max:100',
        ]);

        if ($validated['quantity'] == 0) {
            $this->cartService->remove($validated['menu_id']);
        } else {
            $this->cartService->update($validated['menu_id'], $validated['quantity']);
        }

        return redirect()->back();
    }

    public function removeFromCart(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|integer',
        ]);

        $this->cartService->remove($validated['menu_id']);

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        $cartDetails = $this->cartService->getCartDetails();

        if (empty($cartDetails['items'])) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        return view('public.checkout', compact('cartDetails'));
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'table_number' => 'required|string|max:50',
        ]);

        $cartDetails = $this->cartService->getCartDetails();

        if (empty($cartDetails['items'])) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        try {
            $order = $this->checkoutService->process(
                $cartDetails['items'],
                $validated,
                $cartDetails['total_price']
            );

            // Clear the cart on successful order
            $this->cartService->clear();

            return redirect()->route('checkout.success', ['order' => $order->id])
                             ->with('success', 'Order created successfully! Please proceed to the cashier.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function success(Request $request, $order)
    {
        return view('public.success', compact('order'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }
}
