@extends('layouts.staff')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-200 pb-8 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-amber-700">Staff Dashboard</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight text-stone-900">Monitor the cafe floor in one place.</h1>
            <p class="mt-3 max-w-2xl text-stone-600">Track today’s orders, review the recent queue, and keep an eye on category performance.</p>
        </div>
        <a href="{{ route('staff.orders.index') }}" class="inline-flex rounded-full bg-stone-900 px-5 py-3 font-semibold text-white transition hover:bg-amber-900">
            Open Order Queue
        </a>
    </div>

    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-[2rem] border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Total Orders</p>
            <p class="mt-3 text-4xl font-black text-stone-900">{{ $data['total_orders'] }}</p>
        </div>
        <div class="rounded-[2rem] border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Orders Today</p>
            <p class="mt-3 text-4xl font-black text-amber-900">{{ $data['orders_today'] }}</p>
        </div>
        <div class="rounded-[2rem] border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">In Progress</p>
            <p class="mt-3 text-4xl font-black text-orange-600">{{ $data['orders_in_progress'] }}</p>
        </div>
        <div class="rounded-[2rem] border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Unpaid</p>
            <p class="mt-3 text-4xl font-black text-yellow-600">{{ $data['orders_unpaid'] }}</p>
        </div>
    </div>

    <div class="mt-8 grid gap-8 xl:grid-cols-[1.3fr_0.7fr]">
        <section class="rounded-[2rem] border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-200 px-6 py-5">
                <h2 class="text-xl font-bold text-stone-900">Recent Orders</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($data['recent_orders'] as $order)
                            <tr class="hover:bg-amber-50/40">
                                <td class="px-6 py-4">
                                    <a href="{{ route('staff.orders.show', $order) }}" class="font-bold text-amber-900 hover:underline">{{ $order->order_code }}</a>
                                </td>
                                <td class="px-6 py-4 text-stone-700">{{ $order->customer_name }}</td>
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
                                <td colspan="4" class="px-6 py-12 text-center text-stone-500">No recent orders available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-[2rem] border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-stone-900">Sales by Category</h2>
            <div class="mt-6 space-y-4">
                @forelse($data['sales_by_category'] as $category => $total)
                    <div class="rounded-2xl bg-stone-50 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <p class="font-semibold text-stone-800">{{ $category }}</p>
                            <p class="font-bold text-amber-900">IDR {{ number_format($total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-stone-300 bg-stone-50 p-6 text-center text-stone-500">
                        Sales data will appear after orders are created.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
