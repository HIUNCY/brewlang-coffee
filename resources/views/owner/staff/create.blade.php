@extends('layouts.owner')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('owner.staff.index') }}" class="text-gray-500 hover:text-gray-900">&larr; Back to Staff List</a>
        <h1 class="text-3xl font-extrabold text-gray-900">Add Staff Account</h1>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r text-red-800 shadow-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow sm:rounded-lg border border-gray-100">
        <form action="{{ route('owner.staff.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Display Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zinc-500 focus:ring-zinc-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zinc-500 focus:ring-zinc-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required minlength="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-zinc-500 focus:ring-zinc-500">
                    <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters long.</p>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-zinc-800 hover:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
