@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 border-b border-stone-200 pb-8 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-amber-700">Cart</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight text-stone-900">Review your order before checkout.</h1>
        </div>
        <a href="{{ route('menu') }}" class="inline-flex rounded-full border border-stone-300 px-5 py-3 font-semibold text-stone-700 transition hover:border-amber-300 hover:text-amber-900">
            Continue Browsing
        </a>
    </div>

    <div class="mt-10 grid gap-8 lg:grid-cols-[1fr_360px]">
        <div class="space-y-4">
            @forelse($cartItems as $item)
                <article class="rounded-[2rem] border border-stone-200 bg-white p-6 shadow-sm" data-cart-item="{{ $item['menu_id'] }}">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-stone-900">{{ $item['name'] }}</h2>
                            <p class="mt-1 text-sm text-stone-500">IDR {{ number_format($item['price'], 0, ',', '.') }} each</p>
                            <p class="mt-3 text-sm font-semibold text-amber-900">Subtotal: IDR {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </div>
                        <button type="button" class="js-remove-item inline-flex rounded-full border border-red-200 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50" data-menu-id="{{ $item['menu_id'] }}">
                            Remove
                        </button>
                    </div>

                    <div class="mt-5 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                        <div class="flex items-center gap-3">
                            <button type="button" class="js-quantity-change h-11 w-11 rounded-full border border-stone-300 text-lg font-bold text-stone-700 transition hover:border-amber-300 hover:text-amber-900" data-menu-id="{{ $item['menu_id'] }}" data-quantity="{{ $item['quantity'] - 1 }}">
                                -
                            </button>
                            <div class="rounded-full bg-stone-100 px-5 py-3 text-sm font-bold text-stone-900">
                                Qty {{ $item['quantity'] }}
                            </div>
                            <button type="button" class="js-quantity-change h-11 w-11 rounded-full border border-stone-300 text-lg font-bold text-stone-700 transition hover:border-amber-300 hover:text-amber-900" data-menu-id="{{ $item['menu_id'] }}" data-quantity="{{ $item['quantity'] + 1 }}">
                                +
                            </button>
                        </div>

                        <label class="block w-full lg:max-w-sm">
                            <span class="mb-2 block text-sm font-semibold text-stone-700">Item note</span>
                            <textarea class="js-note-input w-full rounded-2xl border border-stone-300 px-4 py-3 text-sm text-stone-700 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" rows="3" data-menu-id="{{ $item['menu_id'] }}" placeholder="Less sugar, no ice, extra shot...">{{ $item['note'] }}</textarea>
                        </label>
                    </div>
                </article>
            @empty
                <x-empty-state
                    title="Your cart is empty"
                    description="Add items from the menu to start an order."
                    action-label="Browse Menu"
                    :action-href="route('menu')"
                />
            @endforelse
        </div>

        <aside class="rounded-[2rem] border border-stone-200 bg-stone-900 p-6 text-white shadow-xl shadow-stone-900/10">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-300">Summary</p>
            <div class="mt-6 space-y-3 border-b border-white/10 pb-6">
                <div class="flex items-center justify-between text-sm text-stone-300">
                    <span>Items</span>
                    <span>{{ $cartItems->sum('quantity') }}</span>
                </div>
                <div class="flex items-center justify-between text-sm text-stone-300">
                    <span>Service</span>
                    <span>Free</span>
                </div>
                <div class="flex items-end justify-between pt-4">
                    <span class="text-base font-semibold text-white">Total</span>
                    <span class="text-3xl font-black">IDR {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($cartItems->isEmpty())
                <button type="button" disabled class="mt-6 w-full rounded-2xl bg-white/10 px-5 py-4 font-semibold text-white/50">
                    Checkout unavailable
                </button>
            @else
                <form action="{{ route('checkout.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="customer_name" class="mb-2 block text-sm font-semibold text-stone-200">Customer name</label>
                        <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-stone-400 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-200/30" required>
                        @error('customer_name')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="customer_phone" class="mb-2 block text-sm font-semibold text-stone-200">Phone number</label>
                        <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-stone-400 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-200/30" required>
                        @error('customer_phone')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="customer_email" class="mb-2 block text-sm font-semibold text-stone-200">Email address</label>
                        <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-stone-400 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-200/30" required>
                        @error('customer_email')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="table_number" class="mb-2 block text-sm font-semibold text-stone-200">Table number</label>
                        <input id="table_number" name="table_number" type="text" value="{{ old('table_number') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-stone-400 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-200/30" required>
                        @error('table_number')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>
                    @error('cart')<p class="text-sm text-red-300">{{ $message }}</p>@enderror
                    <button type="submit" class="w-full rounded-2xl bg-amber-400 px-5 py-4 font-bold text-stone-950 transition hover:bg-amber-300">
                        Place Order
                    </button>
                </form>
            @endif
        </aside>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let debounce;

    const send = async (url, method, body) => {
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: body ? JSON.stringify(body) : null,
        });

        if (response.ok) {
            window.location.reload();
        }
    };

    document.querySelectorAll('.js-quantity-change').forEach((button) => {
        button.addEventListener('click', () => {
            send('{{ route('cart.updateQuantity') }}', 'POST', {
                menu_id: button.dataset.menuId,
                quantity: Number(button.dataset.quantity),
            });
        });
    });

    document.querySelectorAll('.js-remove-item').forEach((button) => {
        button.addEventListener('click', () => {
            send(`/cart/remove/${button.dataset.menuId}`, 'DELETE');
        });
    });

    document.querySelectorAll('.js-note-input').forEach((input) => {
        input.addEventListener('input', () => {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                send('{{ route('cart.updateNote') }}', 'POST', {
                    menu_id: input.dataset.menuId,
                    note: input.value,
                });
            }, 500);
        });
    });
});
</script>
@endsection
