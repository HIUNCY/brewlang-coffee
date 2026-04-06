<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        $orders = Order::whereIn('status', ['unpaid', 'paid', 'in_progress'])
            ->with('items.menu')
            ->orderBy('created_at', 'asc')
            ->get();

        $metrics = [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_completed' => Order::whereDate('created_at', today())->where('status', 'all_done')->count(),
            'active_orders' => $orders->count(),
        ];

        return view('staff.dashboard', compact('orders', 'metrics'));
    }

    public function advanceStatus(Request $request, Order $order)
    {
        $flow = Order::STATUS_FLOW;
        if (!isset($flow[$order->status])) {
            return redirect()->back()->with('error', 'Cannot advance order status.');
        }

        $nextStatus = $flow[$order->status];
        
        $order->status = $nextStatus;
        $order->save();

        if ($order->customer_email) {
            \Illuminate\Support\Facades\Mail::to($order->customer_email)
                ->send(new \App\Mail\OrderStatusUpdatedMail($order));
        }

        return redirect()->back()->with('success', 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' marked as ' . $order->status_label);
    }
}
