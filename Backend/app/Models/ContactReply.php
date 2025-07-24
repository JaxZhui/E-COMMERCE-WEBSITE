<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'user_id',
        'subject',
        'message',
        'sent_at',
        'is_sent',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'is_sent' => 'boolean',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
