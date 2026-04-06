@extends('layouts.app')

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
            <x-menu-card :menu="$menu" />
        @empty
            <x-empty-state
                class="md:col-span-2 xl:col-span-3"
                title="No active menu items yet"
                description="There are no available menu items in this category right now. Try another category or check back later."
            />
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
