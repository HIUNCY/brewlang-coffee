@extends('layouts.app')

@section('content')
{{-- Hero Background --}}
<div class="relative flex min-h-[calc(100vh-4rem)] items-center overflow-hidden">
    {{-- Ambient background --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] rounded-full bg-amber-800/20 blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[40%] h-[60%] rounded-full bg-amber-900/15 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_30%_40%,rgba(120,53,15,0.12),transparent_60%)]"></div>
    </div>

    <section class="relative max-w-7xl mx-auto w-full px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-28">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:gap-12">

            {{-- Left: Hero copy --}}
            <div class="animate-fade-in-up">
                <p class="mb-4 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-amber-400/80 sm:mb-6 sm:text-xs sm:tracking-[0.3em]">
                    <span class="h-px w-5 bg-amber-400/50 sm:w-6"></span>
                    Brewlang Coffee
                </p>
                <h1 class="font-display text-4xl font-black tracking-tight text-stone-50 sm:text-6xl lg:text-7xl leading-[1.05]">
                    Where every sip
                    <span class="text-gradient-amber"> tells a story.</span>
                </h1>
                <p class="mt-5 max-w-xl text-base leading-7 text-stone-400 sm:mt-6 sm:text-lg sm:leading-8">
                    Browse our handcrafted menu, add to cart, and place your order directly from your table. Warm drinks, real flavors.
                </p>
                <div class="mt-8 grid gap-3 sm:mt-10 sm:flex sm:flex-wrap sm:gap-4">
                    <a href="{{ route('menu') }}" class="btn-primary glow-amber justify-center">
                        <i class="fa-solid fa-utensils text-sm"></i>
                        Browse Menu
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn-secondary justify-center">
                        <i class="fa-solid fa-bag-shopping text-sm"></i>
                        View Cart
                    </a>
                </div>

                {{-- Stats --}}
                <div class="mt-10 grid grid-cols-3 gap-3 sm:mt-14 sm:flex sm:gap-8">
                    <div>
                        <p class="text-2xl font-black text-stone-100 sm:text-3xl">9</p>
                        <p class="mt-1 text-[10px] uppercase tracking-widest text-stone-500 sm:text-xs">Menu Items</p>
                    </div>
                    <div class="border-l border-stone-800 pl-3 sm:pl-8">
                        <p class="text-2xl font-black text-stone-100 sm:text-3xl">100%</p>
                        <p class="mt-1 text-[10px] uppercase tracking-widest text-stone-500 sm:text-xs">Fresh Daily</p>
                    </div>
                    <div class="border-l border-stone-800 pl-3 sm:pl-8">
                        <p class="text-2xl font-black text-stone-100 sm:text-3xl">Fast</p>
                        <p class="mt-1 text-[10px] uppercase tracking-widest text-stone-500 sm:text-xs">Table Service</p>
                    </div>
                </div>
            </div>

            {{-- Right: Featured Items --}}
            <div class="animate-fade-in-up delay-200">
                <div class="rounded-3xl border border-stone-800 bg-stone-900/80 p-4 backdrop-blur-sm sm:p-6">
                    <div class="mb-5 flex items-center justify-between gap-3 sm:mb-6">
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400/70">Featured Today</p>
                        <a href="{{ route('menu') }}" class="text-xs font-semibold text-stone-500 hover:text-amber-400 transition flex items-center gap-1">
                            See all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recommendedMenus as $menu)
                            <article class="group rounded-2xl border border-stone-800 bg-stone-800/50 p-4 transition hover:border-amber-400/20 hover:bg-stone-800">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-stone-500">{{ $menu->category?->name }}</p>
                                        <h2 class="mt-0.5 text-base font-bold text-stone-100 truncate">{{ $menu->name }}</h2>
                                        <p class="mt-1 text-xs leading-5 text-stone-500 line-clamp-1">{{ $menu->description ?: 'Freshly prepared and served daily.' }}</p>
                                    </div>
                                    <span class="w-fit flex-shrink-0 rounded-full bg-amber-400/10 border border-amber-400/20 px-2.5 py-1 text-xs font-bold text-amber-400">
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
