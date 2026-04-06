@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 text-center transform transition-all">
        <div class="bg-gradient-to-br from-green-400 to-green-600 p-8 flex justify-center">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-inner">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>
        
        <div class="p-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">Order Received!</h2>
            <p class="text-lg text-gray-500 mb-8">Thank you for your order. Please proceed to the cashier and mention your Order #.</p>
            
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 inline-block w-full mb-8 shadow-inner">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Your Order Number</p>
                <div class="text-5xl font-black text-amber-900 tracking-widest">
                    #{{ str_pad($order, 4, '0', STR_PAD_LEFT) }}
                </div>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('home') }}" class="w-full inline-flex justify-center items-center px-6 py-4 border border-transparent shadow-sm text-lg font-bold rounded-xl text-white bg-amber-900 hover:bg-amber-950 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Order More
                </a>
            </div>
        </div>
    </div>
    
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>If you have any questions, please approach our staff.</p>
    </div>
</div>
@endsection
