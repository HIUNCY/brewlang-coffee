@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 border-b border-stone-800 pb-8 sm:flex-row sm:items-end sm:justify-between animate-fade-in-up">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400/70">Our Menu</p>
            <h1 class="font-display mt-3 text-4xl font-black tracking-tight text-stone-50 sm:text-5xl">
                Choose what you love.
            </h1>
            <p class="mt-3 max-w-xl text-stone-500">Filter by category, add items to your cart, and proceed when ready.</p>
        </div>
        <a href="{{ route('cart.index') }}" class="btn-secondary flex-shrink-0">
            <i class="fa-solid fa-bag-shopping text-sm"></i>
            View Cart
        </a>
    </div>

    {{-- Category Filter --}}
    <div class="mt-8 flex flex-wrap gap-2.5 animate-fade-in-up delay-100">
        <a href="{{ route('menu') }}"
           class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-bold transition
                  {{ !$category ? 'bg-amber-400 text-stone-950 shadow-lg shadow-amber-400/20' : 'bg-stone-800 text-stone-400 border border-stone-700 hover:border-amber-400/30 hover:text-amber-400' }}">
            <i class="fa-solid fa-border-all text-xs"></i>
            All
        </a>
        @foreach($categories as $categoryItem)
            @php $slug = str($categoryItem->name)->lower()->replace(' ', '-'); @endphp
            <a href="{{ route('menu', ['category' => $slug]) }}"
               class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-bold transition
                      {{ $category === (string) $slug ? 'bg-amber-400 text-stone-950 shadow-lg shadow-amber-400/20' : 'bg-stone-800 text-stone-400 border border-stone-700 hover:border-amber-400/30 hover:text-amber-400' }}">
                {{ $categoryItem->name }}
            </a>
        @endforeach
    </div>

    {{-- Menu Grid --}}
    <div class="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-3 animate-fade-in-up delay-200">
        @forelse($menus as $menu)
            <x-menu-card :menu="$menu" />
        @empty
            <x-empty-state
                class="md:col-span-2 xl:col-span-3"
                title="No items in this category"
                description="There are no available menu items here right now. Try another category or check back later."
            />
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.querySelectorAll('.js-add-to-cart').forEach((button) => {
        button.addEventListener('click', async () => {
            const icon = button.querySelector('.js-cart-icon');
            const text = button.querySelector('.js-cart-text');

            button.disabled = true;
            if (icon) icon.className = 'fa-solid fa-spinner fa-spin text-xs js-cart-icon';
            if (text) text.textContent = 'Adding...';

            const response = await fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({ menu_id: button.dataset.menuId, quantity: 1 }),
            });

            if (response.ok) {
                if (icon) icon.className = 'fa-solid fa-check text-xs js-cart-icon';
                if (text) text.textContent = 'Added!';

                const badge = document.getElementById('cart-badge');
                if (badge) {
                    const current = parseInt(badge.textContent.trim()) || 0;
                    badge.textContent = current + 1;
                    badge.classList.add('animate-cart-bounce');
                    badge.addEventListener('animationend', () => badge.classList.remove('animate-cart-bounce'), { once: true });
                }

                setTimeout(() => {
                    if (icon) icon.className = 'fa-solid fa-plus text-xs js-cart-icon';
                    if (text) text.textContent = 'Add to cart';
                    button.disabled = false;
                }, 1500);
            } else {
                if (icon) icon.className = 'fa-solid fa-plus text-xs js-cart-icon';
                if (text) text.textContent = 'Add to cart';
                button.disabled = false;
            }
        });
    });
});
</script>
@endsection
