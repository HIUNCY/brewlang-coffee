<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RecommendedMenuService
{
    public function getRecommended(int $limit = 3): Collection
    {
        $recommended = Menu::active()
            ->with('category')
            ->withSum('orderItems as total_ordered', 'quantity')
            ->orderByDesc('total_ordered')
            ->limit($limit)
            ->get();

        if ($recommended->count() < $limit) {
            $existing = $recommended->pluck('id');
            $fallback = Menu::active()
                ->with('category')
                ->whereNotIn('id', $existing)
                ->latest()
                ->limit($limit - $recommended->count())
                ->get();

            $recommended = $recommended->merge($fallback);
        }

        return $recommended;
    }
}
