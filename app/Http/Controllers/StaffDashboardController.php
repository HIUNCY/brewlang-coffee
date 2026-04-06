<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(): View
    {
        $data = [
            'total_orders' => Order::count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'orders_in_progress' => Order::where('status', 'in_progress')->count(),
            'orders_unpaid' => Order::where('status', 'unpaid')->count(),
            'recent_orders' => Order::latest()->limit(5)->get(),
            'sales_by_category' => OrderItem::join('menus', 'order_items.menu_id', '=', 'menus.id')
                ->join('categories', 'menus.category_id', '=', 'categories.id')
                ->selectRaw('categories.name, SUM(order_items.subtotal) as total')
                ->groupBy('categories.name')
                ->pluck('total', 'name'),
        ];

        return view('staff.dashboard', compact('data'));
    }
}
