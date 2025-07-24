<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope for unread contacts
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope for read contacts
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class);
    }
}
