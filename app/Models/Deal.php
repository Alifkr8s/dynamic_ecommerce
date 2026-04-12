<?php

namespace App\Models;

<<<<<<< HEAD
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
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'product_id',
        'title',
        'description',
        'min_participants',
        'current_participants',
        'current_price',
        'deadline',
        'status',
    ];

    protected $casts = [
        'current_price' => 'decimal:2',
        'deadline'      => 'datetime',
    ];

    // Relationships
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function tiers()
    {
        return $this->hasMany(DealTier::class)->orderBy('min_count', 'asc');
    }

    public function participants()
    {
        return $this->hasMany(DealParticipant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helpers
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->deadline);
    }

    public function isGoalReached()
    {
        return $this->current_participants >= $this->min_participants;
    }

    public function remainingSlots()
    {
        return max(0, $this->min_participants - $this->current_participants);
    }

    public function deadlineCountdown()
    {
        if ($this->isExpired()) {
            return 'Expired';
        }
        return Carbon::now()->diff($this->deadline)->format('%d days %H hrs %I mins');
    }

    public function calculateCurrentPrice()
    {
        $tiers = $this->tiers()->orderBy('min_count', 'desc')->get();
        foreach ($tiers as $tier) {
            if ($this->current_participants >= $tier->min_count) {
                return $tier->price;
            }
        }
        return $this->product->base_price;
    }

    // Auto cancel if expired and min not reached
    public function checkAndCancel()
    {
        if ($this->isExpired() && !$this->isGoalReached() && !$this->isCancelled() && !$this->isCompleted()) {
            $this->update(['status' => 'cancelled']);
            return true;
        }
        return false;
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
    }
}