@extends('layouts.owner')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('owner.expenses.index') }}" class="text-gray-500 hover:text-gray-900">&larr; Back to Expenses</a>
        <h1 class="text-3xl font-extrabold text-gray-900">Record Expense</h1>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r text-red-800 shadow-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow sm:rounded-lg border border-gray-100">
        <form action="{{ route('owner.expenses.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Expense Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Coffee Beans Restock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount (Rp)</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" required min="0.01" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Expense Date</label>
                    <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Record Expense
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
