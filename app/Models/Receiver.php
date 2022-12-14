<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperReceiver
 */
class Receiver extends Model
{
    const TYPE_PERSON = 'person';

    const TYPE_GROUP = 'group';

    use HasFactory;

    /**
     * Get receiver's types
     *
     * @return string[]
     */
    public static function getTypes(): array
    {
        return [
            static::TYPE_PERSON,
            static::TYPE_GROUP,
        ];
    }

    /**
     * Receiver belongs to sender
     *
     * @return BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Sender::class);
    }

    /**
     * Receiver has many log messages
     *
     * @return HasMany
     */
    public function logMessages(): HasMany
    {
        return $this->hasMany(LogMessage::class);
    }

    /**
     * Determine whether receiver is a person
     *
     * @return bool
     */
    public function isPerson(): bool
    {
        return $this->type === static::TYPE_PERSON;
    }

    /**
     * Determine whether receiver is a group
     *
     * @return bool
     */
    public function isGroup(): bool
    {
        return $this->type === static::TYPE_GROUP;
    }

    /**
     * Determine whether receiver has log messages
     *
     * @return bool
     */
    public function hasLogMessages(): bool
    {
        return $this->logMessages()->exists();
    }
}
