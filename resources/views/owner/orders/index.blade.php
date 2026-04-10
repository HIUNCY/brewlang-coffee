@extends('layouts.owner')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-800 pb-6 mb-8 lg:flex-row lg:items-end lg:justify-between animate-fade-in-up">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Management</p>
            <h1 class="font-display mt-2 text-3xl font-black text-stone-50">All Orders</h1>
        </div>
    </div>

    <div class="space-y-4 md:hidden animate-fade-in-up delay-100">
        @forelse($orders as $order)
            <article class="rounded-2xl border border-stone-800 bg-stone-900 p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <a href="{{ route('owner.orders.show', $order) }}" class="font-bold text-amber-400 hover:text-amber-300 transition">{{ $order->order_code }}</a>
                        <p class="mt-1 text-xs text-stone-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <x-order-status-badge :status="$order->status" />
                </div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl border border-stone-800 bg-stone-800/60 p-3">
                        <p class="text-[11px] uppercase tracking-wider text-stone-500">Customer</p>
                        <p class="mt-1 text-sm font-semibold text-stone-200">{{ $order->customer_name }}</p>
                        <p class="mt-1 text-xs text-stone-500">Table {{ $order->table_number }}</p>
                    </div>
                    <div class="rounded-xl border border-stone-800 bg-stone-800/60 p-3">
                        <p class="text-[11px] uppercase tracking-wider text-stone-500">Total</p>
                        <p class="mt-1 text-sm font-semibold text-stone-200">IDR {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </article>
        @empty
            <x-empty-state title="No orders available" description="Customer orders will show up here after checkout." />
        @endforelse
    </div>

    <div class="hidden overflow-hidden rounded-2xl border border-stone-800 bg-stone-900 md:block animate-fade-in-up delay-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-dark">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('owner.orders.show', $order) }}" class="font-bold text-amber-400 hover:text-amber-300 transition">{{ $order->order_code }}</a>
                                <p class="mt-0.5 text-xs text-stone-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </td>
                            <td>
                                <p class="font-semibold text-stone-200">{{ $order->customer_name }}</p>
                                <p class="text-xs text-stone-600 mt-0.5">Table {{ $order->table_number }}</p>
                            </td>
                            <td><x-order-status-badge :status="$order->status" /></td>
                            <td class="text-right font-semibold text-stone-200">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8">
                                <x-empty-state title="No orders available" description="Customer orders will show up here after checkout." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
