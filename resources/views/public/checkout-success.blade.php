@extends('layouts.app')

@section('content')
<div class="flex min-h-[70vh] items-center justify-center px-4 py-12">
    <div class="w-full max-w-xl rounded-[2rem] border border-emerald-200 bg-white p-10 text-center shadow-xl shadow-emerald-100/40">
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100">
            <svg class="h-12 w-12 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="mt-8 text-sm font-semibold uppercase tracking-[0.28em] text-emerald-700">Checkout Complete</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-stone-900">Your order has been placed.</h1>
        <p class="mt-4 text-lg leading-8 text-stone-600">
            Please proceed to the cashier to complete your payment and mention the order code below.
        </p>
        <div class="mt-8 rounded-[2rem] bg-stone-100 p-6">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-stone-500">Order Code</p>
            <p class="mt-3 text-4xl font-black tracking-[0.18em] text-amber-900">{{ $orderCode }}</p>
        </div>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('menu') }}" class="rounded-full bg-amber-900 px-6 py-3 font-semibold text-white transition hover:bg-amber-950">Back to Menu</a>
            <a href="{{ route('home') }}" class="rounded-full border border-stone-300 px-6 py-3 font-semibold text-stone-700 transition hover:border-amber-300 hover:text-amber-900">Home</a>
        </div>
    </div>
</div>
@endsection
