@extends('layouts.staff')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col gap-4 border-b border-stone-800 pb-6 mb-8 sm:flex-row sm:items-center sm:justify-between animate-fade-in-up">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400/70">Management</p>
            <h1 class="font-display mt-2 text-3xl font-black text-stone-50">Menu Management</h1>
        </div>
        <a href="{{ route('staff.menus.create') }}" class="btn-primary !rounded-xl glow-amber flex-shrink-0">
            <i class="fa-solid fa-plus text-sm"></i>
            New Menu Item
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-dark mb-6 flex items-center gap-3 animate-fade-in-up">
            <i class="fa-solid fa-circle-check text-emerald-400 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-stone-800 bg-stone-900 overflow-hidden animate-fade-in-up delay-100">
        <div class="overflow-x-auto">
            <table class="min-w-full table-dark">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price (Rp)</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr>
                        <td>
                            @if($menu->photo)
                                <img src="{{ Storage::url($menu->photo) }}" class="h-10 w-10 rounded-xl object-cover border border-stone-700">
                            @else
                                <div class="h-10 w-10 rounded-xl bg-stone-800 border border-stone-700 flex items-center justify-center">
                                    <i class="fa-solid fa-image text-stone-600 text-xs"></i>
                                </div>
                            @endif
                        </td>
                        <td class="font-semibold text-stone-200">{{ rtrim($menu->name, ' *') }}</td>
                        <td class="text-stone-500 text-sm">{{ $menu->category->name }}</td>
                        <td class="font-semibold text-stone-300 text-sm">{{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="rounded-full border px-3 py-1 text-xs font-bold
                                {{ $menu->is_active ? 'bg-emerald-400/10 text-emerald-400 border-emerald-400/30' : 'bg-stone-800 text-stone-500 border-stone-700' }}">
                                <i class="fa-solid {{ $menu->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }} text-[10px] mr-1"></i>
                                {{ $menu->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-3">
                                <form action="{{ route('staff.menus.toggle', $menu) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-semibold text-stone-500 hover:text-amber-400 transition">
                                        {{ $menu->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <a href="{{ route('staff.menus.edit', $menu) }}" class="text-xs font-semibold text-stone-500 hover:text-amber-400 transition">
                                    <i class="fa-solid fa-pen text-[10px]"></i>
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8">
                            <x-empty-state
                                title="No menu items found"
                                description="Create your first menu item to start selling products."
                                :action-href="route('staff.menus.create')"
                                action-label="Create Menu Item"
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
