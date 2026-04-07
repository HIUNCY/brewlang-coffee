@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">

    <div class="max-w-xl mb-12 animate-fade-in-up">
        <p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.3em] text-amber-400/70 mb-5">
            <span class="w-5 h-px bg-amber-400/40"></span>
            Get In Touch
        </p>
        <h1 class="font-display text-4xl font-black tracking-tight text-stone-50 sm:text-5xl">
            Say hello anytime.
        </h1>
        <p class="mt-4 text-stone-500">Have questions, feedback, or just want to connect? We'd love to hear from you.</p>
    </div>

    <div class="grid gap-8 md:grid-cols-2 animate-fade-in-up delay-100">

        {{-- Contact Info --}}
        <div class="space-y-4">
            <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-envelope text-amber-400 text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-stone-500 uppercase tracking-widest font-semibold">Email</p>
                    <p class="mt-1 text-sm text-stone-200 font-medium">hello@brewlang.test</p>
                </div>
            </div>
            <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-phone text-amber-400 text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-stone-500 uppercase tracking-widest font-semibold">Phone</p>
                    <p class="mt-1 text-sm text-stone-200 font-medium">+62 812-3456-7890</p>
                </div>
            </div>
            <div class="rounded-2xl border border-stone-800 bg-stone-900 p-5 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-location-dot text-amber-400 text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-stone-500 uppercase tracking-widest font-semibold">Address</p>
                    <p class="mt-1 text-sm text-stone-200 font-medium">123 Coffee Street, Tech City, 10110</p>
                </div>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6">
            <h2 class="font-display text-xl font-bold text-stone-100 mb-6">Send a message</h2>
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Name</label>
                    <input type="text" class="input-dark" placeholder="Your name">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Email</label>
                    <input type="email" class="input-dark" placeholder="you@email.com">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Message</label>
                    <textarea rows="4" class="input-dark resize-none" placeholder="What's on your mind?"></textarea>
                </div>
                <button type="button" class="btn-primary w-full !rounded-2xl glow-amber mt-2">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                    Send Message
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
