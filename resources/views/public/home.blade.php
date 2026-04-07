@extends('layouts.app')

@section('content')
{{-- Hero Background --}}
<div class="relative min-h-[90vh] flex items-center overflow-hidden">
    {{-- Ambient background --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] rounded-full bg-amber-800/20 blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[40%] h-[60%] rounded-full bg-amber-900/15 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_30%_40%,rgba(120,53,15,0.12),transparent_60%)]"></div>
    </div>

    <section class="relative max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">

            {{-- Left: Hero copy --}}
            <div class="animate-fade-in-up">
                <p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.3em] text-amber-400/80 mb-6">
                    <span class="w-6 h-px bg-amber-400/50"></span>
                    Brewlang Coffee
                </p>
                <h1 class="font-display text-5xl font-black tracking-tight text-stone-50 sm:text-6xl lg:text-7xl leading-[1.05]">
                    Where every sip
                    <span class="text-gradient-amber"> tells a story.</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-stone-400">
                    Browse our handcrafted menu, add to cart, and place your order directly from your table. Warm drinks, real flavors.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('menu') }}" class="btn-primary glow-amber">
                        <i class="fa-solid fa-utensils text-sm"></i>
                        Browse Menu
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn-secondary">
                        <i class="fa-solid fa-bag-shopping text-sm"></i>
                        View Cart
                    </a>
                </div>

                {{-- Stats --}}
                <div class="mt-14 flex gap-8">
                    <div>
                        <p class="text-3xl font-black text-stone-100">50+</p>
                        <p class="text-xs text-stone-500 mt-1 uppercase tracking-widest">Menu Items</p>
                    </div>
                    <div class="border-l border-stone-800 pl-8">
                        <p class="text-3xl font-black text-stone-100">100%</p>
                        <p class="text-xs text-stone-500 mt-1 uppercase tracking-widest">Fresh Daily</p>
                    </div>
                    <div class="border-l border-stone-800 pl-8">
                        <p class="text-3xl font-black text-stone-100">Fast</p>
                        <p class="text-xs text-stone-500 mt-1 uppercase tracking-widest">Table Service</p>
                    </div>
                </div>
            </div>

            {{-- Right: Featured Items --}}
            <div class="animate-fade-in-up delay-200">
                <div class="rounded-3xl border border-stone-800 bg-stone-900/80 p-6 backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400/70">Featured Today</p>
                        <a href="{{ route('menu') }}" class="text-xs font-semibold text-stone-500 hover:text-amber-400 transition flex items-center gap-1">
                            See all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recommendedMenus as $menu)
                            <article class="group rounded-2xl border border-stone-800 bg-stone-800/50 p-4 transition hover:border-amber-400/20 hover:bg-stone-800">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-stone-500">{{ $menu->category?->name }}</p>
                                        <h2 class="mt-0.5 text-base font-bold text-stone-100 truncate">{{ $menu->name }}</h2>
                                        <p class="mt-1 text-xs leading-5 text-stone-500 line-clamp-1">{{ $menu->description ?: 'Freshly prepared and served daily.' }}</p>
                                    </div>
                                    <span class="flex-shrink-0 rounded-full bg-amber-400/10 border border-amber-400/20 px-2.5 py-1 text-xs font-bold text-amber-400">
                                        IDR {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    class="js-add-to-cart mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-xl bg-amber-400/10 border border-amber-400/20 px-3 py-2 text-xs font-bold text-amber-400 transition hover:bg-amber-400 hover:text-stone-950 active:scale-95"
                                    data-menu-id="{{ $menu->id }}"
                                >
                                    <i class="fa-solid fa-plus text-[10px] js-cart-icon"></i>
                                    <span class="js-cart-text">Add to cart</span>
                                </button>
                            </article>
                        @empty
                            <div class="rounded-2xl border border-dashed border-stone-700 bg-stone-800/30 p-8 text-center">
                                <i class="fa-solid fa-mug-hot text-stone-600 text-2xl mb-3"></i>
                                <p class="text-sm text-stone-600">Recommended items will appear here once menu data is available.</p>
                            </div>
                        @endforelse
                    </div>
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
            const icon = button.querySelector('.js-cart-icon');
            const text = button.querySelector('.js-cart-text');

            // Optimistic UI feedback
            button.disabled = true;
            icon.className = 'fa-solid fa-spinner fa-spin text-[10px] js-cart-icon';
            text.textContent = 'Adding...';

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
                icon.className = 'fa-solid fa-check text-[10px] js-cart-icon';
                text.textContent = 'Added!';

                // Update cart badge
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    const current = parseInt(badge.textContent.trim()) || 0;
                    badge.textContent = current + 1;
                    badge.classList.add('animate-cart-bounce');
                    badge.addEventListener('animationend', () => badge.classList.remove('animate-cart-bounce'), { once: true });
                }

                setTimeout(() => {
                    icon.className = 'fa-solid fa-plus text-[10px] js-cart-icon';
                    text.textContent = 'Add to cart';
                    button.disabled = false;
                }, 1500);
            } else {
                icon.className = 'fa-solid fa-plus text-[10px] js-cart-icon';
                text.textContent = 'Add to cart';
                button.disabled = false;
            }
        });
    });
});
</script>
@endsection
