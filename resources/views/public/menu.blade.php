@extends('layouts.app')

@php
    $placeholder = asset('images/menu-placeholder.svg');
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 border-b border-stone-200 pb-8 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-amber-700">Menu</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight text-stone-900">Choose what you want to order.</h1>
            <p class="mt-3 max-w-2xl text-stone-600">Filter by category, add items to cart, and continue to checkout when you are ready.</p>
        </div>
        <a href="{{ route('cart.index') }}" class="inline-flex rounded-full border border-stone-300 px-5 py-3 font-semibold text-stone-700 transition hover:border-amber-300 hover:text-amber-900">
            View Cart
        </a>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('menu') }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $category ? 'bg-white text-stone-700 border border-stone-300' : 'bg-amber-900 text-white' }}">
            All
        </a>
        @foreach($categories as $categoryItem)
            @php
                $slug = str($categoryItem->name)->lower()->replace(' ', '-');
            @endphp
            <a href="{{ route('menu', ['category' => $slug]) }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $category === (string) $slug ? 'bg-amber-900 text-white' : 'bg-white text-stone-700 border border-stone-300' }}">
                {{ $categoryItem->name }}
            </a>
        @endforeach
    </div>

    <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($menus as $menu)
            <article class="overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-sm">
                <img src="{{ $menu->photo_url ?? $placeholder }}" alt="{{ $menu->name }}" class="h-56 w-full object-cover">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-stone-500">{{ $menu->category?->name }}</p>
                            <h2 class="mt-1 text-2xl font-bold text-stone-900">{{ $menu->name }}</h2>
                        </div>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-900">
                            IDR {{ number_format($menu->price, 0, ',', '.') }}
                        </span>
                    </div>
                    <p class="mt-4 min-h-12 text-sm leading-6 text-stone-600">{{ $menu->description ?: 'Freshly made in our kitchen and coffee bar.' }}</p>
                    <button
                        type="button"
                        class="js-add-to-cart mt-6 inline-flex w-full items-center justify-center rounded-2xl bg-stone-900 px-4 py-3 font-semibold text-white transition hover:bg-amber-900"
                        data-menu-id="{{ $menu->id }}"
                    >
                        Add to cart
                    </button>
                </div>
            </article>
        @empty
            <div class="rounded-[2rem] border border-dashed border-stone-300 bg-stone-50 p-10 text-center text-stone-500 md:col-span-2 xl:col-span-3">
                No active menu items are available in this category yet.
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.querySelectorAll('.js-add-to-cart').forEach((button) => {
        button.addEventListener('click', async () => {
            const response = await fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    menu_id: button.dataset.menuId,
                    quantity: 1,
                }),
            });

            if (response.ok) {
                window.location.reload();
            }
        });
    });
});
</script>
@endsection
