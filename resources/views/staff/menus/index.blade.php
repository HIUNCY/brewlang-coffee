@extends('layouts.staff')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Menu Management</h1>
        <a href="{{ route('staff.menus.create') }}" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition">
            + New Menu Item
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (Rp)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($menus as $menu)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($menu->photo)
                            <img src="{{ Storage::url($menu->photo) }}" class="h-10 w-10 rounded object-cover">
                        @else
                            <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center text-gray-400">
                                No Img
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ rtrim($menu->name, ' *') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $menu->category->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ number_format($menu->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $menu->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <form action="{{ route('staff.menus.toggle', $menu) }}" method="POST" class="inline-block mr-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-gray-500 hover:text-gray-700 font-bold">
                                {{ $menu->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <a href="{{ route('staff.menus.edit', $menu) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No menu items found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
