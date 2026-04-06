@extends('layouts.owner')

@section('content')
<style>
@media print {
    aside { display: none !important; }
    .no-print { display: none !important; }
    body { background-color: #fff !important; }
    main { padding: 0 !important; width: 100% !important; margin: 0 !important; }
    .shadow { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
}
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Business Report</h1>
        </div>
        <div class="no-print">
            <button onclick="window.print()" class="bg-zinc-800 hover:bg-zinc-900 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Report
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-8 no-print">
        <form action="{{ route('owner.reports.index') }}" method="GET" class="flex items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" name="date_from" value="{{ $date_from }}" class="rounded-md border-gray-300 shadow-sm focus:border-zinc-500 focus:ring-zinc-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="date_to" value="{{ $date_to }}" class="rounded-md border-gray-300 shadow-sm focus:border-zinc-500 focus:ring-zinc-500">
            </div>
            <button type="submit" class="bg-white text-zinc-800 border border-zinc-300 hover:bg-zinc-50 font-bold py-2 px-4 rounded shadow-sm transition">Generate</button>
        </form>
    </div>

    <!-- Print Header -->
    <div class="hidden print:block mb-8 text-center border-b pb-4">
        <h2 class="text-2xl font-bold">Brewlang Financial Report</h2>
        <p class="text-gray-600">Period: {{ \Carbon\Carbon::parse($date_from)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($date_to)->format('M d, Y') }}</p>
    </div>

    <!-- Report Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
            <p class="text-sm font-medium text-emerald-600 mb-1">Income Expected / Paid</p>
            <p class="text-3xl font-bold text-emerald-700">Rp {{ number_format($total_income, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
            <p class="text-sm font-medium text-red-600 mb-1">Total Expenses</p>
            <p class="text-3xl font-bold text-red-700">Rp {{ number_format($total_expenses, 0, ',', '.') }}</p>
        </div>
        <div class="bg-zinc-900 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-zinc-400 mb-1">Net Period Result</p>
            <p class="text-3xl font-bold text-white">Rp {{ number_format($total_income - $total_expenses, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tables Side by Side -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Orders -->
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="bg-emerald-50 px-4 py-3 border-b border-emerald-100">
                <h3 class="text-lg font-bold text-emerald-900">Income Log</h3>
            </div>
            <div class="max-h-[500px] overflow-y-auto print:max-h-none">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">ID</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 text-sm font-medium">#{{ $order->order_code }}</td>
                                <td class="px-4 py-2 text-sm text-right font-medium text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6">
                                    <x-empty-state
                                        class="p-6"
                                        title="No income records"
                                        description="There are no orders within the selected report period."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Expenses -->
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="bg-red-50 px-4 py-3 border-b border-red-100">
                <h3 class="text-lg font-bold text-red-900">Expense Log</h3>
            </div>
            <div class="max-h-[500px] overflow-y-auto print:max-h-none">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Item</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($expenses as $exp)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ \Carbon\Carbon::parse($exp->expense_date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 text-sm font-medium">{{ $exp->title }}</td>
                                <td class="px-4 py-2 text-sm text-right font-medium text-red-600">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6">
                                    <x-empty-state
                                        class="p-6"
                                        title="No expense records"
                                        description="There are no expenses within the selected report period."
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
