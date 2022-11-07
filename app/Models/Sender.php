<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSender
 */
class Sender extends Model
{
    use HasFactory;

    /**
     * Sender belongs to user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sender has many receivers
     *
     * @return HasMany
     */
    public function receivers(): HasMany
    {
        return $this->hasMany(Receiver::class);
    }

    /**
     * Sender has many log messages
     *
     * @return HasMany
     */
    public function logMessages(): HasMany
    {
        return $this->hasMany(LogMessage::class);
    }
}
