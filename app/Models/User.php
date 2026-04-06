<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['is_active' => 'boolean', 'password' => 'hashed'];

    public function isOwner(): bool  { return $this->role === 'owner'; }
    public function isStaff(): bool  { return $this->role === 'staff'; }
    public function isActive(): bool { return $this->is_active; }

    public function expenses(): HasMany { return $this->hasMany(Expense::class); }
}
