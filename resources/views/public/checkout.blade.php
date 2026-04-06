@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('home') }}" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Complete Your Order</h1>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        <!-- Order Summary -->
        <div class="md:col-span-3 order-2 md:order-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-900">Order Summary</h2>
                </div>
                <div class="p-6">
                    <div class="divide-y divide-gray-100">
                        @foreach($cartDetails['items'] as $item)
                        <div class="py-4 flex justify-between items-center group first:pt-0 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl bg-amber-50 flex items-center justify-center text-amber-900/20">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M2.002 9.63c-.023.411.207.794.581.956l7.503 3.243a1.99 1.99 0 0 0 1.579 0l7.504-3.243a.999.999 0 0 0 .58-.956V8.406c0-.422-.249-.809-.643-.984L12.502 4.1a1.999 1.999 0 0 0-1.745 0L4.153 7.422C3.759 7.597 3.51 7.984 3.51 8.406v1.224h-1.508zM12 5.954l5.362 2.381L12 10.638 6.638 8.335 12 5.954zM2.002 14v4.5A2.5 2.5 0 0 0 4.502 21h15a2.5 2.5 0 0 0 2.5-2.5V14c0 1.38-5.373 2.5-12 2.5S2.002 15.38 2.002 14zm0-2.5v1.228C2.964 13.565 6.46 14.5 12 14.5s9.036-.935 9.998-1.772V11.5c0 1.38-5.373 2.5-12 2.5S2.002 12.88 2.002 11.5z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $item['menu']->name }}</h3>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }} × IDR {{ number_format($item['menu']->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="font-bold text-gray-900">
                                IDR {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100">
                    <div class="flex justify-between items-end">
                        <span class="text-gray-500 font-medium">Total Amount</span>
                        <span class="text-3xl font-extrabold text-amber-900">IDR {{ number_format($cartDetails['total_price'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="md:col-span-2 order-1 md:order-2">
            <div class="bg-amber-900 rounded-3xl shadow-xl p-8 text-white sticky top-6">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Customer Details
                </h2>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="customer_name" class="block text-sm font-medium text-amber-100 mb-2">Display Name</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                            class="block w-full bg-white/10 border border-amber-800/50 text-white rounded-xl py-3 px-4 placeholder-amber-200/50 shadow-inner focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all sm:text-base" 
                            placeholder="John Doe">
                        @error('customer_name')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="customer_email" class="block text-sm font-medium text-amber-100 mb-2">Email Address</label>
                        <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required
                            class="block w-full bg-white/10 border border-amber-800/50 text-white rounded-xl py-3 px-4 placeholder-amber-200/50 shadow-inner focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all sm:text-base" 
                            placeholder="john@example.com">
                        @error('customer_email')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="table_number" class="block text-sm font-medium text-amber-100 mb-2">Table Number</label>
                        <input type="text" name="table_number" id="table_number" value="{{ old('table_number') }}" required
                            class="block w-full bg-white/10 border border-amber-800/50 text-white rounded-xl py-3 px-4 placeholder-amber-200/50 shadow-inner focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all sm:text-base" 
                            placeholder="e.g. 12">
                        @error('table_number')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-white text-amber-900 hover:bg-amber-50 font-bold py-4 px-4 rounded-xl shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-amber-900 focus:ring-white flex justify-center items-center gap-2 text-lg">
                        Place Order
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                    
                    <div class="mt-6 text-center flex items-center justify-center gap-2 text-amber-300/60 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Secure ordering process
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
