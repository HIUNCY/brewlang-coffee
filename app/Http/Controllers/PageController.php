<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('public.about');
    }

    public function contact(): View
    {
        return view('public.contact');
    }
}
