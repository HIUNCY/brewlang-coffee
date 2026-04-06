<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Brewlang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex min-h-screen">
    <aside class="w-64 bg-blue-800 text-white flex-shrink-0 min-h-screen flex flex-col">
        <div class="p-4 font-bold text-xl border-b border-blue-700 flex justify-between items-center">
            Brewlang Staff
        </div>
        
        <nav class="p-4 flex-grow space-y-2">
            <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-700">Dashboard / Orders</a>
            <a href="{{ route('staff.menus.index') }}" class="block px-4 py-2 rounded hover:bg-blue-700">Menu Management</a>
        </nav>
        
        <div class="p-4 border-t border-blue-700">
            <div class="mb-2 font-medium">{{ auth()->user()->name }}</div>
            <div class="mb-4 text-sm text-blue-200 capitalize text-xs">Role: {{ auth()->user()->role }}</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 bg-blue-900 rounded hover:bg-blue-950 transition">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-grow p-8 w-full overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>
