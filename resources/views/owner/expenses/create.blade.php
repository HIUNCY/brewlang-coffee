@extends('layouts.owner')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in-up">
    <div class="mb-5 flex items-center gap-3 sm:mb-6">
        <a href="{{ route('owner.expenses.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-stone-500 hover:text-amber-400 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back to Expenses
        </a>
    </div>

    <div>
        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-amber-400/70 sm:text-xs sm:tracking-[0.3em]">Finance</p>
        <h1 class="font-display mt-2 text-2xl font-black text-stone-50 mb-5 sm:mb-6 sm:text-3xl">Record Expense</h1>
    </div>

    @if($errors->any())
        <div class="alert-error-dark mb-6 flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5 flex-shrink-0"></i>
            <ul class="text-sm list-disc pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-stone-800 bg-stone-900 p-4 sm:p-6">
        <form action="{{ route('owner.expenses.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Expense Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="input-dark" placeholder="e.g. Coffee Beans Restock">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Description <span class="normal-case text-stone-700">(Optional)</span></label>
                <textarea name="description" rows="3" class="input-dark resize-none" placeholder="Short description...">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Amount (Rp)</label>
                <input type="number" name="amount" value="{{ old('amount') }}" required min="0.01" step="0.01"
                    class="input-dark" placeholder="0">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Expense Date</label>
                <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required
                    class="input-dark">
            </div>
            <div class="pt-2">
                <button type="submit" class="btn-primary glow-amber min-h-12 w-full !rounded-2xl">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    Record Expense
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
