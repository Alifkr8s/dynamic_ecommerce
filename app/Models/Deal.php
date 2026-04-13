<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Deal extends Model
{
    protected $fillable = [
        'product_name',
        'base_price',
        'min_participants',
        'end_time'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'end_time'   => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function participants()
    {
        return $this->belongsToMany(User::class, 'deal_user');
    }

    /*
    |--------------------------------------------------------------------------
    | Dynamic Pricing
    |--------------------------------------------------------------------------
    */

    public function getCurrentPriceAttribute()
    {
        $participantCount = $this->participants()->count();

        $tier = DB::table('price_tiers')
            ->where('deal_id', $this->id)
            ->where('min_participants', '<=', $participantCount)
            ->orderBy('min_participants', 'desc')
            ->first();

        return $tier ? $tier->tier_price : $this->base_price;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function participantCount()
    {
        return $this->participants()->count();
    }

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->end_time);
    }

    public function isGoalReached()
    {
        return $this->participantCount() >= $this->min_participants;
    }

    public function remainingSlots()
    {
        return max(0, $this->min_participants - $this->participantCount());
    }

    public function deadlineCountdown()
    {
        if ($this->isExpired()) {
            return 'Expired';
        }

        return Carbon::now()->diff($this->end_time)->format('%d days %H hrs %I mins');
    }

    /*
    |--------------------------------------------------------------------------
    | Auto Cancel Logic
    |--------------------------------------------------------------------------
    */

    public function checkAndCancel()
    {
        if ($this->isExpired() && !$this->isGoalReached()) {
            return true;
        }

        return false;
    }
}