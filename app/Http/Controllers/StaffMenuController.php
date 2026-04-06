<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Support\Facades\Storage;

class StaffMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->orderBy('category_id')->get();
        return view('staff.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('staff.menus.create', compact('categories'));
    }

    public function store(StoreMenuRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('menus', 'public');
        }

        $data['is_active'] = $request->has('is_active') ? true : false;
        
        Menu::create($data);

        return redirect()->route('staff.menus.index')->with('success', 'Menu item added successfully.');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('staff.menus.edit', compact('menu', 'categories'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }
            $data['photo'] = $request->file('photo')->store('menus', 'public');
        }

        $data['is_active'] = $request->has('is_active') ? true : false;

        $menu->update($data);

        return redirect()->route('staff.menus.index')->with('success', 'Menu item updated successfully.');
    }

    public function toggleActive(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);

        return redirect()->back()->with('success', 'Menu item status updated.');
    }
}
