<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperLogMessage
 */
class LogMessage extends Model
{
    const STATUS_PENDING = 'pending';

    const STATUS_SENT = 'sent';

    const STATUS_FAILED = 'failed';

    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $dates = [
        'sent_at',
        'failed_at',
    ];

    /**
     * Log message belongs to sender
     *
     * @return BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Sender::class);
    }

    /**
     * Log message belongs to receiver
     *
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Sender::class);
    }

    /**
     * Determine whether log message is pending
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === static::STATUS_PENDING;
    }

    /**
     * Determine whether log message is sent
     *
     * @return bool
     */
    public function isSent(): bool
    {
        return $this->status === static::STATUS_SENT;
    }

    /**
     * Determine whether log message is failed
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === static::STATUS_FAILED;
    }
}
