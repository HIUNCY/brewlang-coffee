@extends('layouts.staff')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-800 pb-6 mb-8 lg:flex-row lg:items-end lg:justify-between animate-fade-in-up">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Queue</p>
            <h1 class="font-display mt-2 text-3xl font-black text-stone-50">Order Queue</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-dark mb-6 flex items-center gap-3 animate-fade-in-up">
            <i class="fa-solid fa-circle-check text-emerald-400 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error-dark mb-6 flex items-center gap-3 animate-fade-in-up">
            <i class="fa-solid fa-circle-exclamation text-red-400 flex-shrink-0"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-2xl border border-stone-800 bg-stone-900 overflow-hidden animate-fade-in-up delay-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-dark">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <p class="font-bold text-amber-400">{{ $order->order_code }}</p>
                                <p class="text-xs text-stone-600 mt-0.5">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </td>
                            <td>
                                <p class="font-semibold text-stone-200">{{ $order->customer_name }}</p>
                                <p class="text-xs text-stone-600 mt-0.5">Table {{ $order->table_number }}</p>
                            </td>
                            <td class="text-stone-500 text-sm">{{ $order->items->sum('quantity') }} items</td>
                            <td><x-order-status-badge :status="$order->status" /></td>
                            <td class="text-right">
                                <a href="{{ route('staff.orders.show', $order) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-stone-400 hover:text-amber-400 transition">
                                    Open <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8">
                                <x-empty-state title="No orders in the queue" description="New customer orders will appear here once checkout is completed." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
