@extends('layouts.owner')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8 animate-fade-in-up">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Overview</p>
        <h1 class="font-display mt-2 text-3xl font-black text-stone-50">Owner Dashboard</h1>
        <p class="text-stone-500 mt-1 text-sm">Business performance at a glance.</p>
    </div>

    {{-- Metric Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-fade-in-up delay-100">
        {{-- Total Orders --}}
        <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Orders</p>
                <div class="w-9 h-9 rounded-xl bg-stone-800 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-stone-400 text-sm"></i>
                </div>
            </div>
            <p class="mt-3 text-3xl font-black text-stone-100">{{ number_format($data['total_orders']) }}</p>
        </div>

        {{-- Total Income --}}
        <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Income</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-400/10 border border-emerald-400/20 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-trend-up text-emerald-400 text-sm"></i>
                </div>
            </div>
            <p class="mt-3 text-2xl font-black text-emerald-400">Rp {{ number_format($data['total_income'], 0, ',', '.') }}</p>
        </div>

        {{-- Total Expenses --}}
        <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Expenses</p>
                <div class="w-9 h-9 rounded-xl bg-red-400/10 border border-red-400/20 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-trend-down text-red-400 text-sm"></i>
                </div>
            </div>
            <p class="mt-3 text-2xl font-black text-red-400">Rp {{ number_format($data['total_expenses'], 0, ',', '.') }}</p>
        </div>

        {{-- Net Profit --}}
        <div class="rounded-2xl border border-amber-400/20 bg-amber-400/5 p-5 glow-amber">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-400/60">Net Profit</p>
                <div class="w-9 h-9 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                    <i class="fa-solid fa-sack-dollar text-amber-400 text-sm"></i>
                </div>
            </div>
            <p class="mt-3 text-2xl font-black text-gradient-amber">Rp {{ number_format($data['net_profit'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Monthly Chart --}}
    @php
        // Build last 6 months labels
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('Y-m'));
        $monthLabels  = $months->map(fn($m) => \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y'));
        $incomeData   = $months->map(fn($m) => (float) ($data['monthly_income'][$m]  ?? 0));
        $expenseData  = $months->map(fn($m) => (float) ($data['monthly_expenses'][$m] ?? 0));
    @endphp

    <div class="rounded-2xl border border-stone-800 bg-stone-900 p-6 mb-6 animate-fade-in-up delay-200">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <i class="fa-solid fa-chart-bar text-amber-400/60 mr-1.5"></i>
                    Revenue vs Expenses
                </p>
                <p class="mt-1 text-sm text-stone-600">Last 6 months</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-xs font-semibold">
                <span class="flex items-center gap-1.5 text-emerald-400">
                    <span class="w-3 h-3 rounded-sm bg-emerald-400/70 inline-block"></span>
                    Income
                </span>
                <span class="flex items-center gap-1.5 text-red-400">
                    <span class="w-3 h-3 rounded-sm bg-red-400/70 inline-block"></span>
                    Expenses
                </span>
            </div>
        </div>
        <div class="relative" style="height: 240px;">
            <canvas id="monthly-chart"></canvas>
        </div>
    </div>

    {{-- Recent Data Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in-up delay-300">

        {{-- Recent Orders --}}
        <div class="rounded-2xl border border-stone-800 bg-stone-900 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-stone-800">
                <h3 class="font-semibold text-stone-200">
                    <i class="fa-solid fa-receipt text-amber-400/60 mr-2 text-sm"></i>
                    Recent Orders
                </h3>
                <a href="{{ route('owner.orders.index') }}" class="text-xs text-stone-500 hover:text-amber-400 transition flex items-center gap-1">
                    View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <ul class="divide-y divide-stone-800">
                @forelse($data['recent_orders'] as $order)
                <li class="px-5 py-4 hover:bg-stone-800/50 transition">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('owner.orders.show', $order) }}" class="text-sm font-bold text-amber-400 hover:text-amber-300 transition">
                            #{{ $order->order_code }}
                        </a>
                        <span class="text-xs text-stone-600">{{ $order->created_at->format('M d, H:i') }}</span>
                    </div>
                    <div class="mt-1.5 flex items-center justify-between">
                        <span class="text-xs text-stone-500">{{ $order->customer_name }}</span>
                        <span class="text-sm font-bold text-stone-300">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </li>
                @empty
                <li class="px-5 py-8">
                    <x-empty-state title="No recent orders" description="Orders will appear here after customers checkout." />
                </li>
                @endforelse
            </ul>
        </div>

        {{-- Recent Expenses --}}
        <div class="rounded-2xl border border-stone-800 bg-stone-900 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-stone-800">
                <h3 class="font-semibold text-stone-200">
                    <i class="fa-solid fa-wallet text-red-400/60 mr-2 text-sm"></i>
                    Recent Expenses
                </h3>
                <a href="{{ route('owner.expenses.index') }}" class="text-xs text-stone-500 hover:text-amber-400 transition flex items-center gap-1">
                    View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <ul class="divide-y divide-stone-800">
                @forelse($data['recent_expenses'] as $exp)
                <li class="px-5 py-4 hover:bg-stone-800/50 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-stone-200 truncate max-w-[60%]">{{ $exp->title }}</span>
                        <span class="text-xs text-stone-600">{{ \Carbon\Carbon::parse($exp->expense_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="mt-1.5 flex items-center justify-between">
                        <span class="text-xs text-stone-600 truncate max-w-[60%]">{{ Str::limit($exp->description, 40) }}</span>
                        <span class="text-sm font-bold text-red-400">- Rp {{ number_format($exp->amount, 0, ',', '.') }}</span>
                    </div>
                </li>
                @empty
                <li class="px-5 py-8">
                    <x-empty-state title="No recent expenses" description="Expenses will appear here once recorded." />
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(function () {
    const labels   = @json($monthLabels->values());
    const income   = @json($incomeData->values());
    const expenses = @json($expenseData->values());

    const ctx = document.getElementById('monthly-chart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Income',
                    data: income,
                    backgroundColor: 'rgba(52, 211, 153, 0.25)',
                    borderColor: 'rgba(52, 211, 153, 0.7)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Expenses',
                    data: expenses,
                    backgroundColor: 'rgba(248, 113, 113, 0.20)',
                    borderColor: 'rgba(248, 113, 113, 0.6)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: { color: '#78716c', font: { size: 11, family: 'Inter, sans-serif' } },
                    border: { color: 'rgba(255,255,255,0.05)' },
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: {
                        color: '#78716c',
                        font: { size: 11, family: 'Inter, sans-serif' },
                        callback: (val) => 'Rp ' + Intl.NumberFormat('id-ID').format(val),
                    },
                    border: { color: 'rgba(255,255,255,0.05)' },
                },
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1c1917',
                    borderColor: '#44403c',
                    borderWidth: 1,
                    titleColor: '#fafaf9',
                    bodyColor: '#a8a29e',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: (ctx) => ` ${ctx.dataset.label}: Rp ${Intl.NumberFormat('id-ID').format(ctx.raw)}`,
                    },
                },
            },
        },
    });
})();
</script>
@endsection
