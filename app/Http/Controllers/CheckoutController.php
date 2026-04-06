<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private CheckoutService $checkoutService,
    ) {
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cart = $this->cartService;
        $order = $this->checkoutService->checkout(
            $request->validated(),
            $cart->getCart()['items']
        );

        $cart->clearCart();

        return redirect()
            ->route('checkout.success')
            ->with('order_code', $order->order_code);
    }

    public function success(): View|RedirectResponse
    {
        if (!session('order_code')) {
            return redirect()->route('home');
        }

        return view('public.checkout-success', [
            'orderCode' => session('order_code'),
        ]);
    }
}
