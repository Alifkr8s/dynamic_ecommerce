<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'image',
        'base_price',
        'stock_quantity',
        'status',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    // Product belongs to a vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Product can have many deals
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    // Helper: check if product is active
    public function isActive()
    {
        return $this->status === 'active';
    }

    // Helper: check if product is in stock
    public function inStock()
    {
        return $this->stock_quantity > 0;
    }
}