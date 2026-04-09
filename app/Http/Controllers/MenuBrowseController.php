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
        $categorySlug = $request->route('category');
        $categories = Category::with(['menus' => fn ($query) => $query->active()])->get();

        $matchedCategory = $categories->first(function ($category) use ($categorySlug) {
            return $categorySlug !== ''
                && (string) str($category->name)->lower()->replace(' ', '-') === (string) str($categorySlug)->lower();
        });

        $menus = Menu::active()
            ->with('category')
            ->when($matchedCategory, function ($query) use ($matchedCategory) {
                return $query->where('category_id', $matchedCategory->id);
            })
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        $category = $categorySlug;

        return view('public.menu', compact('menus', 'categories', 'category'));
    }
}
