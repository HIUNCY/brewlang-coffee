@extends('layouts.owner')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Staff Accounts</h1>
        <a href="{{ route('owner.staff.create') }}" class="rounded-2xl bg-zinc-800 px-4 py-3 font-bold text-white shadow-sm transition hover:bg-zinc-900">
            + New Staff Account
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[2rem] border border-gray-200 bg-white shadow">
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                        {{ $user->role }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if(!$user->isOwner())
                        <form action="{{ route('owner.staff.toggle', $user) }}" method="POST" class="inline-block mr-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-zinc-600 hover:text-zinc-900 font-bold">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">No staff accounts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
