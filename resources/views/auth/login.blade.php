<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Brewlang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full z-0 pointer-events-none opacity-40">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-amber-300 blur-3xl mix-blend-multiply"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[60%] rounded-full bg-orange-200 blur-3xl mix-blend-multiply"></div>
    </div>

    <div class="w-full max-w-md z-10 p-4">
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/50">
            <!-- Header Section -->
            <div class="bg-gradient-to-br from-amber-800 to-amber-950 p-8 text-center relative border-b-4 border-amber-600">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-4 shadow-xl hover:scale-105 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </a>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Brewlang</h1>
                <p class="text-amber-200 mt-2 text-sm font-medium">Coffee Management System</p>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                @if ($errors->any())
                    <div id="alert-border-2" class="flex items-center p-4 mb-6 text-red-800 border-l-4 border-red-500 bg-red-50 rounded-r-lg" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                        <div class="ms-3 text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"  data-dismiss-target="#alert-border-2" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        </button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div id="alert-1" class="flex items-center p-4 mb-6 text-red-800 rounded-lg bg-red-50 border border-red-100" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                        <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-1" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        </button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6 flex flex-col">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-bold text-gray-900">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/><path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/></svg>
                            </div>
                            <input type="email" name="email" id="email" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 p-3 shadow-sm transition-all focus:shadow-md" required value="{{ old('email') }}" placeholder="admin@brewlang.loc" autofocus>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-bold text-gray-900">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20"><path d="M14 7h-1.5V4.5a4.5 4.5 0 1 0-9 0V7H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-5 8a1 1 0 1 1-2 0v-3a1 1 0 1 1 2 0v3Zm1.5-8h-5V4.5a2.5 2.5 0 1 1 5 0V7Z"/></svg>
                            </div>
                            <input type="password" name="password" id="password" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 p-3 shadow-sm transition-all focus:shadow-md" required placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-amber-800 hover:bg-amber-900 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-xl text-lg px-5 py-3.5 text-center shadow-lg shadow-amber-800/40 transition-all hover:shadow-xl hover:-translate-y-0.5 mt-4">
                        Secure Login
                    </button>
                    <div class="text-sm font-medium text-gray-500 text-center mt-6">
                        Return to <a href="{{ route('home') }}" class="text-amber-700 hover:underline hover:text-amber-800 font-bold">Storefront</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-6 text-sm text-gray-400 font-medium tracking-wide">
            &copy; {{ date('Y') }} Brewlang Internal System
        </div>
    </div>
</body>
</html>
