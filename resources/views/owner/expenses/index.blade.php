@extends('layouts.owner')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-800 pb-6 mb-8 sm:flex-row sm:items-center sm:justify-between animate-fade-in-up">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Finance</p>
            <h1 class="font-display mt-2 text-3xl font-black text-stone-50">Expenses</h1>
        </div>
        <a href="{{ route('owner.expenses.create') }}" class="btn-primary !rounded-xl glow-amber flex-shrink-0">
            <i class="fa-solid fa-plus text-sm"></i>
            Record Expense
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-dark mb-6 flex items-center gap-3 animate-fade-in-up">
            <i class="fa-solid fa-circle-check text-emerald-400 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4 md:hidden animate-fade-in-up delay-100">
        @forelse($expenses as $expense)
            <article class="rounded-2xl border border-stone-800 bg-stone-900 p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-base font-semibold text-stone-200">{{ $expense->title }}</p>
                        <p class="mt-1 text-xs text-stone-500">{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</p>
                    </div>
                    <p class="text-sm font-bold text-red-400">- {{ number_format($expense->amount, 0, ',', '.') }}</p>
                </div>
                @if($expense->description)
                    <p class="mt-3 text-sm leading-6 text-stone-500">{{ $expense->description }}</p>
                @endif
            </article>
        @empty
            <x-empty-state
                title="No expenses recorded"
                description="Add your first expense entry to start tracking operational costs."
                :action-href="route('owner.expenses.create')"
                action-label="Record Expense"
            />
        @endforelse
    </div>

    <div class="hidden overflow-hidden rounded-2xl border border-stone-800 bg-stone-900 md:block animate-fade-in-up delay-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-dark">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th class="text-right">Amount (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>
                        <td class="text-stone-500 text-xs">{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                        <td class="font-bold text-stone-200">{{ $expense->title }}</td>
                        <td class="text-stone-500 text-xs">{{ Str::limit($expense->description, 60) }}</td>
                        <td class="text-right font-bold text-red-400">- {{ number_format($expense->amount, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8">
                            <x-empty-state
                                title="No expenses recorded"
                                description="Add your first expense entry to start tracking operational costs."
                                :action-href="route('owner.expenses.create')"
                                action-label="Record Expense"
                            />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
