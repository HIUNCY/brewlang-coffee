@extends('layouts.app')

@section('content')
<div class="flex min-h-[85vh] items-center justify-center px-4 py-10 sm:py-16">
    <div class="w-full max-w-lg animate-scale-in">
        <div class="rounded-3xl border border-stone-800 bg-stone-900/80 dark-glass p-5 text-center sm:p-10">

            {{-- Success Icon --}}
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full border border-amber-400/20 bg-amber-400/10 glow-amber animate-glow-pulse sm:h-20 sm:w-20">
                <i class="fa-solid fa-circle-check text-2xl text-amber-400 sm:text-3xl"></i>
            </div>

            <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400/70">Checkout Complete</p>
            <h1 class="font-display mt-3 text-2xl font-black tracking-tight text-stone-50 sm:text-3xl">Your order is placed!</h1>
            <p class="mt-4 text-stone-500 leading-7">
                Please proceed to the cashier to complete your payment and show them the order code below.
            </p>

            {{-- Order Code --}}
            <div class="mt-8 rounded-2xl border border-amber-400/20 bg-amber-400/5 p-4 sm:p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-stone-500">Order Code</p>
                <p class="mt-3 break-all text-3xl font-black tracking-[0.1em] text-gradient-amber sm:text-4xl sm:tracking-[0.15em]">{{ $orderCode }}</p>
            </div>

            {{-- Actions --}}
            <div class="mt-8 grid gap-3 sm:flex sm:flex-wrap sm:justify-center">
                <a href="{{ route('menu') }}" class="btn-primary justify-center">
                    <i class="fa-solid fa-utensils text-sm"></i>
                    Back to Menu
                </a>
                <a href="{{ route('home') }}" class="btn-secondary justify-center">
                    <i class="fa-solid fa-house text-sm"></i>
                    Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
