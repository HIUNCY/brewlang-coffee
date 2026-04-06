<?php

namespace App\Http\Controllers;

use App\Services\RecommendedMenuService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private RecommendedMenuService $recommendedMenuService)
    {
    }

    public function index(): View
    {
        return view('public.home', [
            'recommendedMenus' => $this->recommendedMenuService->getRecommended(),
        ]);
    }
}
