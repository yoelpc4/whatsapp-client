<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receiver extends Model
{
    const TYPE_PERSON = 'person';

    const TYPE_GROUP = 'group';

    use HasFactory;

    /**
     * Get receiver's types
     *
     * @return array<string, string>
     */
    public static function getTypes(): array
    {
        return [
            static::TYPE_PERSON,
            static::TYPE_GROUP,
        ];
    }

    /**
     * Receiver belongs to user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
