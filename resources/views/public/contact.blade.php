@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-extrabold text-amber-900 text-center mb-8">Contact Us</h1>
    <div class="bg-white rounded-xl shadow-sm p-8 text-gray-700 border border-amber-100 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Get In Touch</h2>
            <p class="mb-4">Have questions? We'd love to hear from you. Send us a message or visit our café.</p>
            <div class="space-y-4">
                <p><strong>Email:</strong> hello@brewlang.test</p>
                <p><strong>Phone:</strong> +62 812-3456-7890</p>
                <p><strong>Address:</strong> 123 Coffee Street, Tech City, 10110</p>
            </div>
        </div>
        <div>
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
                </div>
                <button type="button" class="w-full bg-amber-900 text-white font-bold py-2 px-4 rounded-lg hover:bg-amber-800 transition">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
