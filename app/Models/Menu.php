<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'photo', 'is_active'];
    protected $casts    = ['is_active' => 'boolean', 'price' => 'decimal:2'];

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function orderItems(): HasMany  { return $this->hasMany(OrderItem::class); }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }
}
