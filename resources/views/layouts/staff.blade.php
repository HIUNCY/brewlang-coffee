<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Staff Dashboard - Brewlang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-100">
    <div class="flex min-h-screen flex-col lg:flex-row">
    <aside class="flex min-h-screen w-full flex-shrink-0 flex-col bg-stone-950 text-white lg:w-72">
        <div class="border-b border-white/10 p-6">
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-amber-300">Brewlang</p>
            <h1 class="mt-3 text-2xl font-black tracking-tight">Staff Panel</h1>
        </div>
        
        <nav class="flex-grow space-y-2 p-4">
            <a href="{{ route('staff.dashboard') }}" class="block rounded-2xl px-4 py-3 font-semibold transition hover:bg-white/10">Dashboard</a>
            <a href="{{ route('staff.orders.index') }}" class="block rounded-2xl px-4 py-3 font-semibold transition hover:bg-white/10">Orders</a>
            <a href="{{ route('staff.menus.index') }}" class="block rounded-2xl px-4 py-3 font-semibold transition hover:bg-white/10">Menu Management</a>
        </nav>
        
        <div class="border-t border-white/10 p-4">
            <div class="mb-2 font-medium">{{ auth()->user()->name }}</div>
            <div class="mb-4 text-xs uppercase tracking-[0.24em] text-stone-400">Role: {{ auth()->user()->role }}</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full rounded-2xl bg-amber-400 px-4 py-3 text-left font-semibold text-stone-950 transition hover:bg-amber-300">Logout</button>
            </form>
        </div>
    </aside>

    <main class="w-full flex-grow overflow-y-auto p-5 sm:p-8">
        @yield('content')
    </main>
    </div>
</body>
</html>
