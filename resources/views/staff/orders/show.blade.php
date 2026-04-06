@extends('layouts.staff')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('staff.orders.index') }}" class="text-sm font-semibold text-stone-500 hover:text-amber-900">&larr; Back to orders</a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="grid gap-8 lg:grid-cols-[1fr_340px]">
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
            <h2 class="text-xl font-bold text-stone-900">Update Status</h2>
            <p class="mt-2 text-sm leading-6 text-stone-600">Only forward transitions are allowed.</p>

            @if(isset(\App\Models\Order::STATUS_FLOW[$order->status]))
                <form action="{{ route('staff.orders.updateStatus', $order) }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{ \App\Models\Order::STATUS_FLOW[$order->status] }}">
                    <button type="submit" class="w-full rounded-2xl bg-amber-400 px-5 py-4 font-bold text-stone-950 transition hover:bg-amber-300">
                        Mark as {{ match(\App\Models\Order::STATUS_FLOW[$order->status]) {
                            'paid' => 'Paid',
                            'in_progress' => 'In Progress',
                            'all_done' => 'Completed',
                            default => 'Updated'
                        } }}
                    </button>
                </form>
            @else
                <x-empty-state
                    class="mt-6 p-5"
                    title="Order already completed"
                    description="This order has reached its final status and no further transitions are available."
                />
            @endif
        </aside>
    </div>
</div>
@endsection
