<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'min_count',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Tier belongs to a deal
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}