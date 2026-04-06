@extends('layouts.staff')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-200 pb-8 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-amber-700">Orders</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight text-stone-900">Manage the current order queue.</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="mt-8 overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Items</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-amber-50/40">
                            <td class="px-6 py-4">
                                <p class="font-bold text-amber-900">{{ $order->order_code }}</p>
                                <p class="text-sm text-stone-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-stone-900">{{ $order->customer_name }}</p>
                                <p class="text-sm text-stone-500">Table {{ $order->table_number }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-stone-600">{{ $order->items->sum('quantity') }} items</td>
                            <td class="px-6 py-4">
                                <x-order-status-badge :status="$order->status" />
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('staff.orders.show', $order) }}" class="font-semibold text-stone-700 hover:text-amber-900">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8">
                                <x-empty-state
                                    title="No orders in the queue"
                                    description="New customer orders will appear here once checkout is completed."
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
