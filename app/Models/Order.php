<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code', 'customer_name', 'customer_phone',
        'customer_email', 'table_number', 'status', 'total_price',
    ];
    protected $casts = ['total_price' => 'decimal:2'];

    public const STATUS_FLOW = [
        'unpaid'      => 'paid',
        'paid'        => 'in_progress',
        'in_progress' => 'all_done',
    ];

    public function canTransitionTo(string $newStatus): bool
    {
        return isset(self::STATUS_FLOW[$this->status])
            && self::STATUS_FLOW[$this->status] === $newStatus;
    }

    public function items(): HasMany { return $this->hasMany(OrderItem::class); }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'unpaid'      => 'Unpaid',
            'paid'        => 'Paid',
            'in_progress' => 'In Progress',
            'all_done'    => 'Completed',
            default       => ucfirst($this->status),
        };
    }
}
