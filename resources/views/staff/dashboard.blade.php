@extends('layouts.staff')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Staff Dashboard</h1>
            <p class="text-gray-500 mt-1">Manage active orders and track your shift.</p>
        </div>
        
        <div class="flex gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 min-w-[120px]">
                <p class="text-sm text-gray-500 font-medium">Active Orders</p>
                <p class="text-3xl font-bold text-amber-900">{{ $metrics['active_orders'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 min-w-[120px]">
                <p class="text-sm text-gray-500 font-medium">Completed Today</p>
                <p class="text-3xl font-bold text-emerald-600">{{ $metrics['today_completed'] }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900">Current Order Queue</h2>
            
            <button onclick="window.location.reload()" class="text-sm text-gray-500 hover:text-amber-800 flex items-center gap-1 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider text-xs">Order ID</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider text-xs">Customer</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider text-xs">Items</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-wider text-xs">Status</th>
                        <th class="px-6 py-4 text-right font-bold text-gray-400 uppercase tracking-wider text-xs">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($orders as $order)
                        <tr class="hover:bg-amber-50/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-amber-900 text-lg">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $order->customer_name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <ul class="text-sm text-gray-600 space-y-1">
                                    @foreach($order->items as $item)
                                        <li class="flex items-center gap-2">
                                            <span class="font-bold text-gray-900">{{ $item->quantity }}x</span> 
                                            <span>{{ rtrim($item->menu?->name, ' *') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'unpaid' => 'bg-gray-100 text-gray-800 border-gray-200',
                                        'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'in_progress' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    ];
                                    $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $color }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @if(isset(App\Models\Order::STATUS_FLOW[$order->status]))
                                <form action="{{ route('staff.order.advance', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-amber-900 hover:bg-amber-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                                        Mark {{ match(App\Models\Order::STATUS_FLOW[$order->status]) {
                                            'paid' => 'Paid',
                                            'in_progress' => 'In Progress',
                                            'all_done' => 'Completed',
                                            default => 'Next'
                                        } }}
                                        <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                </div>
                                <span class="block font-medium">No active orders right now.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
