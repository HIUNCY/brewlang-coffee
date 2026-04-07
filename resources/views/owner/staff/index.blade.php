@extends('layouts.owner')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-800 pb-6 mb-8 sm:flex-row sm:items-center sm:justify-between animate-fade-in-up">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Management</p>
            <h1 class="font-display mt-2 text-3xl font-black text-stone-50">Staff Accounts</h1>
        </div>
        <a href="{{ route('owner.staff.create') }}" class="btn-primary !rounded-xl glow-amber flex-shrink-0">
            <i class="fa-solid fa-user-plus text-sm"></i>
            New Staff Account
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-dark mb-6 flex items-center gap-3 animate-fade-in-up">
            <i class="fa-solid fa-circle-check text-emerald-400 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error-dark mb-6 flex items-center gap-3 animate-fade-in-up">
            <i class="fa-solid fa-circle-exclamation text-red-400 flex-shrink-0"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-2xl border border-stone-800 bg-stone-900 overflow-hidden animate-fade-in-up delay-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-dark">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center text-amber-400 font-bold text-xs uppercase flex-shrink-0">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-semibold text-stone-200">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-stone-500 text-sm">{{ $user->email }}</td>
                        <td class="capitalize text-stone-400 text-sm">{{ $user->role }}</td>
                        <td>
                            <span class="rounded-full border px-3 py-1 text-xs font-bold
                                {{ $user->is_active ? 'bg-emerald-400/10 text-emerald-400 border-emerald-400/30' : 'bg-red-400/10 text-red-400 border-red-400/30' }}">
                                <i class="fa-solid {{ $user->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }} text-[10px] mr-1"></i>
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-right">
                            @if(!$user->isOwner())
                            <form action="{{ route('owner.staff.toggle', $user) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold
                                    {{ $user->is_active ? 'text-stone-500 hover:text-red-400' : 'text-stone-500 hover:text-emerald-400' }}
                                    transition">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-stone-700">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8">
                            <x-empty-state
                                title="No staff accounts found"
                                description="Create a staff account so the team can access the operational dashboard."
                                :action-href="route('owner.staff.create')"
                                action-label="Create Staff Account"
                            />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
