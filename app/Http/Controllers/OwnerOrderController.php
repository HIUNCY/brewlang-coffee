<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OwnerOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('items')
            ->latest()
            ->get();

        return view('owner.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.menu');

        return view('owner.orders.show', compact('order'));
    }
}
