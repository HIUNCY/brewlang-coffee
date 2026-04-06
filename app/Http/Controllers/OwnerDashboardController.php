<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Expense;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $total_income = Order::whereIn('status', ['paid', 'in_progress', 'all_done'])->sum('total_price');
        $total_expenses = Expense::sum('amount');
        
        $data = [
            'total_orders'   => Order::count(),
            'total_income'   => $total_income,
            'total_expenses' => $total_expenses,
            'net_profit'     => $total_income - $total_expenses,
            'recent_orders'  => Order::latest()->limit(5)->get(),
            'recent_expenses'=> Expense::latest()->limit(5)->get(),
            // Monthly data for chart (last 6 months)
            'monthly_income' => Order::whereIn('status', ['paid', 'in_progress', 'all_done'])
                                   ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as total")
                                   ->where('created_at', '>=', now()->subMonths(6))
                                   ->groupBy('month')
                                   ->pluck('total', 'month'),
            'monthly_expenses' => Expense::selectRaw("DATE_FORMAT(expense_date, '%Y-%m') as month, SUM(amount) as total")
                                   ->where('expense_date', '>=', now()->subMonths(6))
                                   ->groupBy('month')
                                   ->pluck('total', 'month'),
        ];

        return view('owner.dashboard', compact('data'));
    }
}
