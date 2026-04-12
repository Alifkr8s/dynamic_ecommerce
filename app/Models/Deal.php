<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Deal extends Model
{
    protected $fillable = [
        'product_name',
        'base_price',
        'min_participants',
        'end_time'
    ];

    // Participants relationship
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'deal_user');
    }

    // ✅ ACCESSOR (BEST PRACTICE)
    public function getCurrentPriceAttribute()
    {
        $participantCount = $this->users()->count();

        $tier = DB::table('price_tiers')
            ->where('deal_id', $this->id)
            ->where('min_participants', '<=', $participantCount)
            ->orderBy('min_participants', 'desc')
            ->first();

        return $tier ? $tier->tier_price : $this->base_price;
    }
}