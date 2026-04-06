@extends('layouts.owner')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-200 pb-8 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-amber-700">Orders</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight text-stone-900">Review all customer orders.</h1>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-amber-50/40">
                            <td class="px-6 py-4">
                                <a href="{{ route('owner.orders.show', $order) }}" class="font-bold text-amber-900 hover:underline">{{ $order->order_code }}</a>
                                <p class="mt-1 text-sm text-stone-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-stone-900">{{ $order->customer_name }}</p>
                                <p class="text-sm text-stone-500">Table {{ $order->table_number }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-bold
                                    {{ $order->status === 'unpaid' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status === 'paid' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'in_progress' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $order->status === 'all_done' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-stone-900">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-stone-500">No orders available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
