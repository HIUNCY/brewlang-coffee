<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Brewlang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex min-h-screen">
    <aside class="w-64 bg-gray-800 text-white flex-shrink-0 min-h-screen flex flex-col">
        <div class="p-4 font-bold text-xl border-b border-gray-700">Brewlang Owner</div>
        <nav class="p-4 flex-grow space-y-2">
            <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2 rounded hover:bg-zinc-800">Dashboard</a>
            <a href="{{ route('owner.expenses.index') }}" class="block px-4 py-2 rounded hover:bg-zinc-800">Expenses</a>
            <a href="{{ route('owner.staff.index') }}" class="block px-4 py-2 rounded hover:bg-zinc-800">Staff Accounts</a>
            <a href="{{ route('owner.reports.index') }}" class="block px-4 py-2 rounded hover:bg-zinc-800">Reports</a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <div class="mb-2">{{ auth()->user()->name }} (Owner)</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 bg-red-600 rounded hover:bg-red-700">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-grow p-8 w-full overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>
