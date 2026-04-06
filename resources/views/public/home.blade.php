@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8 relative">
        <!-- Main Content: Menu Items -->
        <div class="flex-1">
            <div class="mb-8 p-6 bg-gradient-to-r from-amber-800 to-amber-950 rounded-2xl shadow-xl text-white overflow-hidden relative">
                <div class="absolute top-0 right-0 opacity-10">
                    <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="translate-x-12 -translate-y-12"><path d="M100 0C44.8 0 0 44.8 0 100s44.8 100 100 100 100-44.8 100-100S155.2 0 100 0zm0 180c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"/></svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">Welcome to Brewlang</h1>
                <p class="text-amber-100 text-lg max-w-xl">Enjoy our premium crafted coffee and fresh pastries. Order now.</p>
            </div>

            <!-- Categories -->
            <div class="mb-6 flex overflow-x-auto pb-2 gap-3 snap-x scrollbar-hide">
                <a href="#all" class="flex-none px-6 py-2.5 rounded-full bg-amber-900 text-white font-medium shadow-md transition hover:-translate-y-0.5 whitespace-nowrap">All Items</a>
                @foreach($categories as $category)
                    <a href="#category-{{ $category->id }}" class="flex-none px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-700 hover:bg-amber-50 hover:border-amber-200 hover:text-amber-800 font-medium shadow-sm transition hover:-translate-y-0.5 whitespace-nowrap">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="space-y-10">
                @foreach($categories as $category)
                    @php
                        $categoryMenus = $menus->where('category_id', $category->id);
                    @endphp
                    @if($categoryMenus->count() > 0)
                        <div id="category-{{ $category->id }}" class="scroll-mt-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <span class="bg-amber-100 text-amber-800 p-2 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01"></path></svg>
                                </span>
                                {{ $category->name }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($categoryMenus as $menu)
                                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all overflow-hidden group flex flex-col h-full">
                                        <div class="h-48 bg-gray-100 relative overflow-hidden">
                                            <!-- Placeholder Image for Menu Item -->
                                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-amber-50 to-orange-100 group-hover:scale-105 transition-transform duration-500">
                                                <svg class="w-20 h-20 text-amber-900/20" fill="currentColor" viewBox="0 0 24 24"><path d="M2.002 9.63c-.023.411.207.794.581.956l7.503 3.243a1.99 1.99 0 0 0 1.579 0l7.504-3.243a.999.999 0 0 0 .58-.956V8.406c0-.422-.249-.809-.643-.984L12.502 4.1a1.999 1.999 0 0 0-1.745 0L4.153 7.422C3.759 7.597 3.51 7.984 3.51 8.406v1.224h-1.508zM12 5.954l5.362 2.381L12 10.638 6.638 8.335 12 5.954zM2.002 14v4.5A2.5 2.5 0 0 0 4.502 21h15a2.5 2.5 0 0 0 2.5-2.5V14c0 1.38-5.373 2.5-12 2.5S2.002 15.38 2.002 14zm0-2.5v1.228C2.964 13.565 6.46 14.5 12 14.5s9.036-.935 9.998-1.772V11.5c0 1.38-5.373 2.5-12 2.5S2.002 12.88 2.002 11.5z"/></svg>
                                            </div>
                                            <div class="absolute top-3 right-3">
                                                <span class="bg-amber-900/90 backdrop-blur text-white text-sm font-bold px-3 py-1 rounded-full shadow-sm shadow-amber-900/30">IDR {{ number_format($menu->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <div class="p-5 flex-1 flex flex-col justify-between h-full bg-white relative z-10">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-amber-800 transition-colors">{{ $menu->name }}</h3>
                                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">Authentic flavor, crafted to perfection. Perfect addition to your day.</p>
                                            </div>
                                            
                                            <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                                <button type="submit" class="w-full bg-gray-50 hover:bg-amber-900 hover:text-white text-gray-800 border border-gray-200 transition-all font-semibold rounded-xl py-3 px-4 flex justify-center items-center gap-2 group-hover:shadow-md">
                                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                    Add to Order
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Sidebar: Cart -->
        <div class="w-full lg:w-96 shrink-0 z-40">
            <div class="sticky top-6 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden flex flex-col h-[calc(100vh-3rem)] max-h-[800px]">
                <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center shrink-0">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Your Order
                    </h2>
                    <span class="bg-amber-100 text-amber-800 text-sm font-bold px-2.5 py-0.5 rounded-full">{{ $cartDetails['total_quantity'] }}</span>
                </div>

                <div class="p-5 flex-1 overflow-y-auto scrollbar-thin">
                    @if(empty($cartDetails['items']))
                        <div class="h-full flex flex-col items-center justify-center text-center px-4 py-8">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <h3 class="text-gray-900 font-medium mb-1">Your cart is empty</h3>
                            <p class="text-gray-500 text-sm">Add some delicious items from our menu to get started.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($cartDetails['items'] as $item)
                                <div class="flex flex-col gap-2 p-3 bg-white border border-gray-100 hover:border-amber-200 hover:bg-amber-50/30 rounded-xl transition-colors group">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1 pr-2">
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $item['menu']->name }}</h4>
                                            <p class="text-amber-800 font-medium text-sm">IDR {{ number_format($item['menu']->price, 0, ',', '.') }}</p>
                                        </div>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $item['menu']->id }}">
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Remove item">
                                                <svg class="w-4 h-4" x-description="Heroicon name: outline/x-mark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-xs text-gray-500">Subtotal: IDR {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                        <div class="flex items-center gap-1 bg-gray-50 rounded-lg p-1 border border-gray-200">
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $item['menu']->id }}">
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                                <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-md text-gray-600 hover:bg-white hover:text-amber-700 hover:shadow-sm transition-all" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                                </button>
                                            </form>
                                            
                                            <span class="w-6 text-center text-sm font-bold text-gray-900">{{ $item['quantity'] }}</span>
                                            
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $item['menu']->id }}">
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                                <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-md text-gray-600 hover:bg-white hover:text-amber-700 hover:shadow-sm transition-all">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="p-5 border-t border-gray-100 bg-gray-50 shrink-0">
                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-gray-500 text-sm">
                            <span>Subtotal</span>
                            <span>IDR {{ number_format($cartDetails['total_price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500 text-sm">
                            <span>Service Charge</span>
                            <span class="text-green-600 font-medium">Free</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-end">
                                <span class="text-gray-900 font-medium">Total</span>
                                <span class="text-2xl font-extrabold text-amber-900">IDR {{ number_format($cartDetails['total_price'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if(empty($cartDetails['items']))
                        <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-xl cursor-not-allowed">Checkout</button>
                    @else
                        <a href="{{ route('checkout') }}" class="w-full bg-amber-900 hover:bg-amber-950 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all shadow-amber-900/30 flex justify-center items-center gap-2">
                            Proceed to Checkout
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
