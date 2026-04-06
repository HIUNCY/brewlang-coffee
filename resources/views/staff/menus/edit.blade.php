@extends('layouts.staff')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('staff.menus.index') }}" class="text-gray-500 hover:text-gray-900">&larr; Back to Menu List</a>
        <h1 class="text-3xl font-extrabold text-gray-900">Edit Menu Item</h1>
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

    <div class="bg-white shadow sm:rounded-lg">
        <form action="{{ route('staff.menus.update', $menu) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', rtrim($menu->name, ' *')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', (int)$menu->price) }}" required min="0" step="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $menu->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Photo</label>
                    @if($menu->photo)
                        <img src="{{ Storage::url($menu->photo) }}" class="mt-2 h-32 w-32 object-cover rounded shadow-sm border border-gray-100">
                    @else
                        <p class="mt-2 text-sm text-gray-500">No photo uploaded.</p>
                    @endif
                    
                    <label class="block text-sm font-medium text-gray-700 mt-4">Replace Photo (Optional)</label>
                    <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Max size 2MB (JPG, PNG, WEBP)</p>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Make item active publicly</label>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-800 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Menu Item
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
