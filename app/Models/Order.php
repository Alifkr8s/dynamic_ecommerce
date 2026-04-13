<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deal_id',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Order belongs to a deal
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    // Order has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Order has one invoice
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    // Helper: check if order is delivered
    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    // Helper: check if order is cancelled
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}
