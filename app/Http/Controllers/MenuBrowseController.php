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
        $categorySlug = (string) $request->query('category');
        $categories = Category::with(['menus' => fn ($query) => $query->active()])->get();

        // Match the slug from URL against available category names
        $matchedCategory = $categories->first(function ($c) use ($categorySlug) {
            return str($c->name)->lower()->replace(' ', '-') === $categorySlug;
        });

        $menus = Menu::active()
            ->with('category')
            ->when($matchedCategory, function ($query) use ($matchedCategory) {
                return $query->where('category_id', $matchedCategory->id);
            })
            ->get();

        // We still pass the original slug to the view for highlighting the active filter
        $category = $categorySlug;

        return view('public.menu', compact('menus', 'categories', 'category'));
    }
}
