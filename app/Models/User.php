<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
=======
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0

class User extends Authenticatable
{
    use HasFactory, Notifiable;

<<<<<<< HEAD
    /**
     * The attributes that are mass assignable.
     */
=======
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
    protected $fillable = [
        'name',
        'email',
        'password',
<<<<<<< HEAD
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
=======
        'role',
        'email_verified_at',
    ];

>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELATIONSHIP FOR APURBO'S MODULE:
     * This allows us to track which deals a user has joined.
     * It is essential for "Real-Time Participant Tracking".
     */
    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class);
=======
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function dealParticipations()
    {
        return $this->hasMany(DealParticipant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVendor()
    {
        return $this->role === 'vendor';
    }

    public function isBuyer()
    {
        return $this->role === 'user';
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
    }
}