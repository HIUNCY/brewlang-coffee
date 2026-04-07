@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden">
    {{-- Ambient bg --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[40%] h-[50%] rounded-full bg-amber-900/10 blur-[120px]"></div>
    </div>

    {{-- Hero --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="max-w-2xl animate-fade-in-up">
            <p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.3em] text-amber-400/70 mb-5">
                <span class="w-5 h-px bg-amber-400/40"></span>
                Our Story
            </p>
            <h1 class="font-display text-5xl font-black tracking-tight text-stone-50 sm:text-6xl leading-tight">
                Born from a love of coffee.
            </h1>
            <p class="mt-6 text-lg leading-8 text-stone-400">
                Welcome to <span class="font-bold text-amber-400">Brewlang Coffee</span>. We believe in serving the finest coffee, sourced ethically and brewed to perfection.
            </p>
        </div>

        {{-- Story Cards --}}
        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 animate-fade-in-up delay-200">
            <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6">
                <div class="w-11 h-11 rounded-2xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center mb-5">
                    <i class="fa-solid fa-seedling text-amber-400"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-stone-100">Our Roots</h3>
                <p class="mt-3 text-sm leading-7 text-stone-500">
                    Our journey started in a small roastery. We have mastered the art of espresso, pour-overs, and cold brews. Every cup is a testament to our passion.
                </p>
            </div>
            <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6">
                <div class="w-11 h-11 rounded-2xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center mb-5">
                    <i class="fa-solid fa-fire text-amber-400"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-stone-100">Crafted with Care</h3>
                <p class="mt-3 text-sm leading-7 text-stone-500">
                    Every drink is prepared with precision and passion. We hand-select our beans and brew each order fresh, ensuring consistent quality in every cup.
                </p>
            </div>
            <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6 sm:col-span-2 lg:col-span-1">
                <div class="w-11 h-11 rounded-2xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center mb-5">
                    <i class="fa-solid fa-mug-hot text-amber-400"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-stone-100">Our Promise</h3>
                <p class="mt-3 text-sm leading-7 text-stone-500">
                    Visit us today to experience true coffee craftsmanship. A warm atmosphere, premium drinks, and a checkout experience designed for your table.
                </p>
            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-12 animate-fade-in-up delay-300">
            <a href="{{ route('menu') }}" class="btn-primary glow-amber">
                <i class="fa-solid fa-utensils text-sm"></i>
                Explore Our Menu
            </a>
        </div>
    </div>
</div>
@endsection
