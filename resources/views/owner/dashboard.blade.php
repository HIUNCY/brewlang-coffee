@extends('layouts.owner')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Owner Dashboard</h1>
        <p class="text-gray-500 mt-1">Business performance overview.</p>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Orders</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($data['total_orders']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
            <p class="text-sm font-medium text-emerald-600 mb-1">Total Income</p>
            <p class="text-3xl font-bold text-emerald-700">Rp {{ number_format($data['total_income'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
            <p class="text-sm font-medium text-red-600 mb-1">Total Expenses</p>
            <p class="text-3xl font-bold text-red-700">Rp {{ number_format($data['total_expenses'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-zinc-900 rounded-xl shadow-md border border-zinc-800 p-6 text-white">
            <p class="text-sm font-medium text-zinc-400 mb-1">Net Profit</p>
            <p class="text-3xl font-bold text-white">Rp {{ number_format($data['net_profit'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Orders</h3>
            </div>
            <ul class="divide-y divide-gray-200">
                @foreach($data['recent_orders'] as $order)
                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-amber-900 truncate">#{{ $order->order_code }}</div>
                        <div class="ml-2 flex-shrink-0 flex text-sm text-gray-500">{{ $order->created_at->format('M d, H:i') }}</div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500">{{ $order->customer_name }}</p>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-900 sm:mt-0 font-bold">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Recent Expenses -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Expenses</h3>
            </div>
            <ul class="divide-y divide-gray-200">
                @foreach($data['recent_expenses'] as $exp)
                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $exp->title }}</div>
                        <div class="ml-2 flex-shrink-0 flex text-sm text-gray-500">{{ \Carbon\Carbon::parse($exp->expense_date)->format('M d, Y') }}</div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500 truncate">{{ Str::limit($exp->description, 50) }}</p>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-red-600 sm:mt-0 font-bold">
                            - Rp {{ number_format($exp->amount, 0, ',', '.') }}
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
