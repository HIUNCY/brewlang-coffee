<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Expense;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date_from = $request->query('date_from', now()->startOfMonth()->toDateString());
        $date_to = $request->query('date_to', now()->endOfMonth()->toDateString());

        $ordersQuery = Order::whereIn('status', ['paid', 'in_progress', 'all_done'])
            ->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to);

        $expensesQuery = Expense::whereDate('expense_date', '>=', $date_from)
            ->whereDate('expense_date', '<=', $date_to);

        $total_income = $ordersQuery->sum('total_price');
        $total_expenses = $expensesQuery->sum('amount');
        
        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();
        $expenses = $expensesQuery->orderBy('expense_date', 'desc')->get();

        return view('owner.reports.index', compact(
            'date_from', 'date_to', 'total_income', 'total_expenses', 'orders', 'expenses'
        ));
    }
}
