<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Brewlang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-950 text-stone-50 flex items-center justify-center min-h-screen relative overflow-hidden">

    {{-- Ambient background --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-15%] left-[-10%] w-[50%] h-[55%] rounded-full bg-amber-900/20 blur-[120px]"></div>
        <div class="absolute bottom-[-15%] right-[-5%] w-[45%] h-[50%] rounded-full bg-amber-800/10 blur-[100px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(120,53,15,0.08),transparent_65%)]"></div>
    </div>

    <div class="relative w-full max-w-sm z-10 px-4 py-8 animate-scale-in">

        <div class="rounded-3xl border border-stone-800 bg-stone-900/90 overflow-hidden dark-glass shadow-2xl">

            {{-- Card Header --}}
            <div class="bg-gradient-to-br from-amber-900/80 to-stone-950 border-b border-stone-800 p-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-400/10 border border-amber-400/20 mb-5 transition hover:bg-amber-400/20">
                    <i class="fa-solid fa-mug-hot text-amber-400 text-xl"></i>
                </a>
                <h1 class="font-display text-2xl font-black text-stone-50">Brewlang</h1>
                <p class="mt-1 text-sm text-stone-500">Management System</p>
            </div>

            {{-- Form --}}
            <div class="p-7">
                {{-- Errors --}}
                @if($errors->any())
                    <div class="alert-error-dark mb-5 flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert-error-dark mb-5 flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-red-400 flex-shrink-0"></i>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <i class="fa-solid fa-envelope text-stone-600 text-xs"></i>
                            </div>
                            <input type="email" name="email" id="email"
                                class="input-dark !pl-10"
                                required value="{{ old('email') }}"
                                placeholder="admin@brewlang.loc" autofocus>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <i class="fa-solid fa-lock text-stone-600 text-xs"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="input-dark !pl-10"
                                required placeholder="••••••••">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-primary glow-amber w-full !rounded-2xl mt-2">
                        <i class="fa-solid fa-right-to-bracket text-sm"></i>
                        Secure Login
                    </button>

                    <div class="text-center pt-2">
                        <a href="{{ route('home') }}" class="text-xs text-stone-600 hover:text-amber-400 transition">
                            <i class="fa-solid fa-arrow-left text-[10px] mr-1"></i>
                            Return to Storefront
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center mt-5 text-xs text-stone-700">&copy; {{ date('Y') }} Brewlang Internal System</p>
    </div>

</body>
</html>
