<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('items.menu')
            ->latest()
            ->get();

        return view('staff.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.menu');

        return view('staff.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:paid,in_progress,all_done'],
        ]);

        try {
            app(OrderStatusService::class)->transition($order, $request->status);

            return back()->with('success', 'Order status updated.');
        } catch (\InvalidArgumentException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
