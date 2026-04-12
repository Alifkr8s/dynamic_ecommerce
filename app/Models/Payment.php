<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
<<<<<<< HEAD
    protected $fillable = [
        'user_id',
        'deal_id',
        'amount',
        'payment_method',
        'status'
    ];
=======
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'stripe_payment_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Payment belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Payment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: check if payment is completed
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // Helper: check if payment is refunded
    public function isRefunded()
    {
        return $this->status === 'refunded';
    }
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
}