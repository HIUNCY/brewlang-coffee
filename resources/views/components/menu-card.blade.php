@props([
    'menu',
    'placeholder' => asset('images/menu-placeholder.jpg'),
])

<article {{ $attributes->class('overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-sm') }}>
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
