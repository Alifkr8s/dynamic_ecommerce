<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'amount',
        'issued_at',
    ];

    protected $casts = [
        'amount'    => 'decimal:2',
        'issued_at' => 'datetime',
    ];

    // Invoice belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Helper: generate unique invoice number
    public static function generateNumber()
    {
        $latest = self::latest()->first();
        $next   = $latest ? ((int) substr($latest->invoice_number, -4)) + 1 : 1;
        return 'INV-' . date('Y') . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}