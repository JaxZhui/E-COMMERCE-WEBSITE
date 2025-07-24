<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer', // Changed from 'decimal:2' to 'integer'
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Updated accessor for formatted price - no decimals
    public function getFormattedPriceAttribute(): string
    {
        return 'Tsh ' . number_format($this->price);
    }

    // Updated accessor for price with currency - no decimals
    public function getPriceWithCurrencyAttribute(): string
    {
        return 'Tsh ' . number_format($this->price);
    }
}
