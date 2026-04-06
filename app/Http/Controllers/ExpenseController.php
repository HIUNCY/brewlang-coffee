<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'desc')->get();
        return view('owner.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('owner.expenses.create');
    }

    public function store(StoreExpenseRequest $request)
    {
        Expense::create($request->validated());

        return redirect()->route('owner.expenses.index')->with('success', 'Expense created successfully.');
    }
}
