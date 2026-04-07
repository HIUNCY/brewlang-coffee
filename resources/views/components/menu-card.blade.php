@props([
    'menu',
    'placeholder' => asset('images/menu-placeholder.jpg'),
])

<article {{ $attributes->class('group overflow-hidden rounded-3xl border border-stone-800 bg-stone-900 transition duration-300 hover:border-amber-400/30 hover:shadow-xl hover:shadow-amber-400/5') }}>
    {{-- Image --}}
    <div class="relative h-52 overflow-hidden">
        <img src="{{ $menu->photo_url ?? $placeholder }}"
             alt="{{ $menu->name }}"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        {{-- Gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-stone-900/20 to-transparent"></div>

        {{-- Price badge --}}
        <span class="absolute bottom-3 right-3 rounded-full bg-amber-400/10 border border-amber-400/25 px-3 py-1 text-xs font-bold text-amber-400 backdrop-blur-sm">
            IDR {{ number_format($menu->price, 0, ',', '.') }}
        </span>

        {{-- Category badge --}}
        @if($menu->category)
        <span class="absolute top-3 left-3 rounded-full bg-stone-950/70 border border-stone-700/50 px-2.5 py-1 text-xs font-semibold text-stone-400 backdrop-blur-sm">
            {{ $menu->category?->name }}
        </span>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-5">
        <h2 class="text-lg font-bold text-stone-100 leading-snug">{{ $menu->name }}</h2>
        <p class="mt-2 text-sm leading-6 text-stone-500 line-clamp-2">{{ $menu->description ?: 'Freshly made in our kitchen and coffee bar.' }}</p>

        <button
            type="button"
            class="js-add-to-cart mt-5 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-amber-400 px-4 py-3 text-sm font-bold text-stone-950 transition duration-200 hover:bg-amber-300 active:scale-95"
            data-menu-id="{{ $menu->id }}"
        >
            <i class="fa-solid fa-plus text-xs js-cart-icon"></i>
            <span class="js-cart-text">Add to cart</span>
        </button>
    </div>
</article>
