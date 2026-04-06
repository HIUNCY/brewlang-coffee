<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brewlang Coffee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen selection:bg-amber-200 selection:text-amber-900">
    <nav class="fixed start-0 top-0 z-50 w-full border-b border-gray-200 bg-white/80 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between p-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                <div class="bg-amber-800 text-white p-2 rounded-xl group-hover:bg-amber-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="self-center text-2xl font-extrabold whitespace-nowrap text-amber-900 tracking-tight">Brewlang</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse items-center gap-4">
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-amber-800 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @if(($cartItemCount ?? 0) > 0)
                        <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-amber-900 px-1.5 text-xs font-bold text-white">
                            {{ $cartItemCount }}
                        </span>
                    @endif
                </a>
                
                @auth
                    <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar" class="flex text-sm bg-gray-200 rounded-full md:me-0 focus:ring-4 focus:ring-amber-300 ring-offset-2 transition" type="button">
                        <span class="sr-only">Open user menu</span>
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-800 font-bold uppercase">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownAvatar" class="z-50 hidden w-48 divide-y divide-gray-100 rounded-2xl border border-gray-100 bg-white shadow-xl">
                        <div class="px-4 py-3 text-sm text-gray-900">
                            <div class="font-bold truncate">{{ auth()->user()->name }}</div>
                            <div class="font-medium text-gray-500 truncate">{{ auth()->user()->role }}</div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownUserAvatarButton">
                            @if(auth()->user()->role === 'owner')
                            <li>
                                <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 transition">Dashboard</a>
                            </li>
                            @elseif(auth()->user()->role === 'staff')
                            <li>
                                <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 transition">Dashboard</a>
                            </li>
                            @endif
                        </ul>
                        <div class="py-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">Log out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white bg-amber-800 hover:bg-amber-900 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-xl text-sm px-5 py-2.5 text-center transition shadow-lg shadow-amber-800/30">Login</a>
                @endauth
                
                <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="mt-4 flex flex-col rounded-2xl border border-gray-100 bg-gray-50 p-4 font-bold md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-transparent md:p-0">
                    <li>
                        <a href="{{ route('menu') }}" class="block rounded py-2 px-3 text-gray-900 transition hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-amber-800">Menu</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="block rounded py-2 px-3 text-gray-900 transition hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-amber-800">About</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="block rounded py-2 px-3 text-gray-900 transition hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-amber-800">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full pt-20">
        @yield('content')
    </main>

    <footer class="mt-auto border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <div class="bg-amber-800 text-white p-1.5 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="self-center text-xl font-bold whitespace-nowrap text-amber-900 tracking-tight">Brewlang</span>
                </a>
                <ul class="mb-6 flex flex-wrap items-center text-sm font-medium text-gray-500 sm:mb-0">
                    <li><a href="{{ route('about') }}" class="hover:text-amber-800 transition me-4 md:me-6">About</a></li>
                    <li><a href="{{ route('menu') }}" class="hover:text-amber-800 transition me-4 md:me-6">Menu</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-amber-800 transition">Contact</a></li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center">&copy; {{ date('Y') }} <a href="{{ route('home') }}" class="hover:underline">Brewlang Coffee</a>. Crafted with care.</span>
        </div>
    </footer>
</html>
