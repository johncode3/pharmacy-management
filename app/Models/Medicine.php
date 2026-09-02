<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'generic_name',
        'barcode',
        'price',
        'cost',
        'stock_quantity',
        'expiry_date',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'price' => 'decimal:2',
            'cost' => 'decimal:2',
            'stock_quantity' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Expiry & Stock Business Rules
    public function isExpired(): bool
    {
        return $this->expiry_date->isPast() || $this->expiry_date->isToday();
    }

    public function isNearExpiry(): bool
    {
        return !$this->isExpired() && $this->expiry_date->diffInDays(now()) <= 30;
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= 10;
    }
}