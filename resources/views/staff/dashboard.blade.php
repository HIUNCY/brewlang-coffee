@extends('layouts.staff')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-4 border-b border-stone-800 pb-6 mb-8 lg:flex-row lg:items-end lg:justify-between animate-fade-in-up">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Staff Dashboard</p>
            <h1 class="font-display mt-2 text-3xl font-black text-stone-50">Monitor the café floor.</h1>
            <p class="mt-1 text-sm text-stone-500">Track today's orders, queue status, and category performance.</p>
        </div>
        <a href="{{ route('staff.orders.index') }}" class="btn-primary !rounded-xl glow-amber w-full justify-center sm:w-auto sm:justify-start">
            <i class="fa-solid fa-receipt text-sm"></i>
            Open Order Queue
        </a>
    </div>

    {{-- Metric Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-8 animate-fade-in-up delay-100">
        <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Orders</p>
                <div class="w-9 h-9 rounded-xl bg-stone-800 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-stone-400 text-sm"></i>
                </div>
            </div>
            <p class="mt-3 text-3xl font-black text-stone-100">{{ $data['total_orders'] }}</p>
        </div>
        <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Orders Today</p>
                <div class="w-9 h-9 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-day text-amber-400 text-sm"></i>
                </div>
            </div>
            <p class="mt-3 text-3xl font-black text-amber-400">{{ $data['orders_today'] }}</p>
        </div>
        <div class="rounded-2xl border border-orange-400/20 bg-orange-400/5 p-5">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-orange-400/60">In Progress</p>
                <div class="w-9 h-9 rounded-xl bg-orange-400/10 border border-orange-400/20 flex items-center justify-center">
                    <i class="fa-solid fa-fire text-orange-400 text-sm animate-status-pulse"></i>
                </div>
            </div>
            <p class="mt-3 text-3xl font-black text-orange-400">{{ $data['orders_in_progress'] }}</p>
        </div>
        <div class="rounded-2xl border border-yellow-400/20 bg-yellow-400/5 p-5">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-yellow-400/60">Unpaid</p>
                <div class="w-9 h-9 rounded-xl bg-yellow-400/10 border border-yellow-400/20 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-yellow-400 text-sm"></i>
                </div>
            </div>
            <p class="mt-3 text-3xl font-black text-yellow-400">{{ $data['orders_unpaid'] }}</p>
        </div>
    </div>

    {{-- Tables --}}
    <div class="grid gap-6 xl:grid-cols-[1.3fr_0.7fr] animate-fade-in-up delay-200">

        {{-- Recent Orders --}}
        <div class="rounded-2xl border border-stone-800 bg-stone-900 overflow-hidden">
            <div class="flex flex-col gap-2 px-5 py-4 border-b border-stone-800 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="font-semibold text-stone-200">
                    <i class="fa-solid fa-receipt text-amber-400/60 mr-2 text-sm"></i>
                    Recent Orders
                </h2>
                <a href="{{ route('staff.orders.index') }}" class="text-xs text-stone-500 hover:text-amber-400 transition">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full table-dark">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['recent_orders'] as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('staff.orders.show', $order) }}" class="font-bold text-amber-400 hover:text-amber-300 transition">{{ $order->order_code }}</a>
                                </td>
                                <td class="text-stone-400">{{ $order->customer_name }}</td>
                                <td><x-order-status-badge :status="$order->status" /></td>
                                <td class="text-right font-semibold text-stone-300">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-stone-600 text-sm">No recent orders available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sales by Category --}}
        <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5">
            <h2 class="font-semibold text-stone-200 mb-5">
                <i class="fa-solid fa-chart-bar text-amber-400/60 mr-2 text-sm"></i>
                Sales by Category
            </h2>
            <div class="space-y-3">
                @forelse($data['sales_by_category'] as $category => $total)
                    <div class="rounded-xl bg-stone-800 border border-stone-700 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <p class="font-semibold text-stone-300 text-sm truncate">{{ $category }}</p>
                            <p class="font-bold text-amber-400 text-sm flex-shrink-0">IDR {{ number_format($total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <x-empty-state title="No data yet" description="Sales data will appear after orders." />
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
