@extends('layouts.app')

@section('content')
<div class="flex min-h-[85vh] items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg animate-scale-in">
        <div class="rounded-3xl border border-stone-800 bg-stone-900/80 dark-glass p-10 text-center">

            {{-- Success Icon --}}
            <div class="mx-auto w-20 h-20 rounded-full bg-amber-400/10 border border-amber-400/20 flex items-center justify-center mb-6 glow-amber animate-glow-pulse">
                <i class="fa-solid fa-circle-check text-amber-400 text-3xl"></i>
            </div>

            <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400/70">Checkout Complete</p>
            <h1 class="font-display mt-3 text-3xl font-black tracking-tight text-stone-50">Your order is placed!</h1>
            <p class="mt-4 text-stone-500 leading-7">
                Please proceed to the cashier to complete your payment and show them the order code below.
            </p>

            {{-- Order Code --}}
            <div class="mt-8 rounded-2xl border border-amber-400/20 bg-amber-400/5 p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-stone-500">Order Code</p>
                <p class="mt-3 text-4xl font-black tracking-[0.15em] text-gradient-amber">{{ $orderCode }}</p>
            </div>

            {{-- Actions --}}
            <div class="mt-8 flex justify-center gap-3 flex-wrap">
                <a href="{{ route('menu') }}" class="btn-primary">
                    <i class="fa-solid fa-utensils text-sm"></i>
                    Back to Menu
                </a>
                <a href="{{ route('home') }}" class="btn-secondary">
                    <i class="fa-solid fa-house text-sm"></i>
                    Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
