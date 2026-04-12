<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'user_id',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    // Participant entry belongs to a deal
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    // Participant entry belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}