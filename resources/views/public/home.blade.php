@extends('layouts.app')

@section('content')
<div class="bg-[radial-gradient(circle_at_top,_rgba(251,191,36,0.18),_transparent_45%),linear-gradient(180deg,#fffbeb_0%,#f8fafc_100%)]">
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-amber-700">Brewlang Coffee</p>
                <h1 class="mt-4 max-w-3xl text-4xl font-black tracking-tight text-stone-900 sm:text-5xl lg:text-6xl">
                    Fresh coffee, warm food, and a checkout flow that stays simple.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-stone-600">
                    Browse the menu, add items to your cart, leave a note for each drink, and place your order directly from your table.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('menu') }}" class="inline-flex items-center rounded-full bg-amber-900 px-6 py-3 font-semibold text-white shadow-lg shadow-amber-900/20 transition hover:bg-amber-950">
                        Browse Menu
                    </a>
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center rounded-full border border-stone-300 bg-white px-6 py-3 font-semibold text-stone-700 transition hover:border-amber-300 hover:text-amber-900">
                        View Cart
                    </a>
                </div>
            </div>

            <div class="rounded-[2rem] border border-amber-200/60 bg-white/80 p-6 shadow-xl shadow-amber-100/40 backdrop-blur">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-700">Recommended</p>
                <div class="mt-6 space-y-4">
                    @forelse($recommendedMenus as $menu)
                        <article class="rounded-3xl border border-stone-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-stone-500">{{ $menu->category?->name }}</p>
                                    <h2 class="mt-1 text-xl font-bold text-stone-900">{{ $menu->name }}</h2>
                                    <p class="mt-2 text-sm leading-6 text-stone-600">{{ $menu->description ?: 'Freshly prepared and served daily.' }}</p>
                                </div>
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-900">
                                    IDR {{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <button
                                type="button"
                                class="js-add-to-cart mt-5 inline-flex rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-900"
                                data-menu-id="{{ $menu->id }}"
                            >
                                Add to cart
                            </button>
                        </article>
                    @empty
                        <div class="rounded-3xl border border-dashed border-stone-300 bg-stone-50 p-8 text-center text-stone-500">
                            Recommended items will appear here once menu data is available.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
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
