<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Owner Dashboard — Brewlang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-50">
    <div class="flex min-h-screen flex-col lg:flex-row">

        {{-- Sidebar --}}
        <aside class="flex min-h-screen w-full flex-shrink-0 flex-col bg-stone-900 border-r border-stone-800 lg:w-64">

            {{-- Sidebar Header --}}
            <div class="border-b border-stone-800 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                        <i class="fa-solid fa-mug-hot text-amber-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400/70">Brewlang</p>
                        <h1 class="text-sm font-bold text-stone-200">Owner Panel</h1>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-grow p-3 space-y-1">
                <a href="{{ route('owner.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-center text-sm"></i>
                    Dashboard
                </a>
                <a href="{{ route('owner.orders.index') }}"
                   class="sidebar-link {{ request()->routeIs('owner.orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt w-5 text-center text-sm"></i>
                    Orders
                </a>
                <a href="{{ route('owner.expenses.index') }}"
                   class="sidebar-link {{ request()->routeIs('owner.expenses.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet w-5 text-center text-sm"></i>
                    Expenses
                </a>
                <a href="{{ route('owner.staff.index') }}"
                   class="sidebar-link {{ request()->routeIs('owner.staff.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users w-5 text-center text-sm"></i>
                    Staff Accounts
                </a>
                <a href="{{ route('owner.reports.index') }}"
                   class="sidebar-link {{ request()->routeIs('owner.reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-bar w-5 text-center text-sm"></i>
                    Reports
                </a>
            </nav>

            {{-- User & Logout --}}
            <div class="border-t border-stone-800 p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center text-amber-400 font-bold text-sm uppercase flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-stone-200 text-sm truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-amber-400/60 uppercase tracking-widest">Owner</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl border border-stone-700 px-3 py-2 text-sm font-semibold text-stone-400 hover:text-red-400 hover:border-red-400/40 hover:bg-red-400/5 transition">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="w-full flex-grow bg-stone-950 overflow-y-auto p-5 sm:p-8">
            @yield('content')
        </main>

    </div>
</body>
</html>
