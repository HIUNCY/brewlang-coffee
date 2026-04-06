<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuBrowseController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $categories = Category::with(['menus' => fn ($query) => $query->active()])->get();

        $menus = Menu::active()
            ->with('category')
            ->when($category, fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery
                ->where('name', 'like', '%' . str_replace('-', ' ', $category) . '%')))
            ->get();

        return view('public.menu', compact('menus', 'categories', 'category'));
    }
}
