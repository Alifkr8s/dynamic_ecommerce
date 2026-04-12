<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Notification belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: mark notification as read
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Scope: only unread notifications
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}