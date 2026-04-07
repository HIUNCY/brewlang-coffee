@extends('layouts.owner')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in-up">
    <div class="mb-6">
        <a href="{{ route('owner.staff.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-stone-500 hover:text-amber-400 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back to Staff List
        </a>
    </div>

    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Management</p>
        <h1 class="font-display mt-2 text-3xl font-black text-stone-50 mb-6">Add Staff Account</h1>
    </div>

    @if($errors->any())
        <div class="alert-error-dark mb-6 flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5 flex-shrink-0"></i>
            <ul class="text-sm list-disc pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-stone-800 bg-stone-900 p-6">
        <form action="{{ route('owner.staff.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Display Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input-dark" placeholder="Full name">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="input-dark" placeholder="staff@brewlang.loc">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-stone-500 uppercase tracking-wider">Password</label>
                <input type="password" name="password" required minlength="8" class="input-dark" placeholder="Min. 8 characters">
                <p class="mt-1.5 text-xs text-stone-600">Must be at least 8 characters long.</p>
            </div>
            <div class="pt-2">
                <button type="submit" class="btn-primary glow-amber w-full !rounded-2xl">
                    <i class="fa-solid fa-user-plus text-sm"></i>
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
