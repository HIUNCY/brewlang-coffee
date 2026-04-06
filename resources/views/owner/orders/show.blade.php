@extends('layouts.owner')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('owner.orders.index') }}" class="text-sm font-semibold text-stone-500 hover:text-amber-900">&larr; Back to orders</a>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_320px]">
        <section class="rounded-[2rem] border border-stone-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 border-b border-stone-200 pb-6 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-700">Order Detail</p>
                    <h1 class="mt-3 text-4xl font-black tracking-tight text-stone-900">{{ $order->order_code }}</h1>
                    <p class="mt-2 text-stone-600">{{ $order->customer_name }} • Table {{ $order->table_number }}</p>
                </div>
                <x-order-status-badge :status="$order->status" class="px-4 py-2 text-sm" />
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Email</p>
                    <p class="mt-2 font-semibold text-stone-900">{{ $order->customer_email }}</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Phone</p>
                    <p class="mt-2 font-semibold text-stone-900">{{ $order->customer_phone }}</p>
                </div>
            </div>

            <div class="mt-8 overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Item</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Note</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-4 font-semibold text-stone-900">{{ $item->menu_name_snapshot }}</td>
                                <td class="px-4 py-4 text-stone-700">{{ $item->quantity }}</td>
                                <td class="px-4 py-4 text-stone-700">IDR {{ number_format($item->price_snapshot, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-sm text-stone-500">{{ $item->item_note ?: '-' }}</td>
                                <td class="px-4 py-4 text-right font-semibold text-stone-900">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-stone-50">
                            <td colspan="4" class="px-4 py-4 text-right font-bold text-stone-900">Total</td>
                            <td class="px-4 py-4 text-right font-black text-amber-900">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <aside class="rounded-[2rem] border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-stone-900">Summary</h2>
            <div class="mt-6 space-y-4">
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Items</p>
                    <p class="mt-2 text-2xl font-black text-stone-900">{{ $order->items->sum('quantity') }}</p>
                </div>
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Created</p>
                    <p class="mt-2 font-semibold text-stone-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
