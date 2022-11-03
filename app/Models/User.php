<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * @inheritdoc
     */
    protected $dates = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @inheritdoc
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * User has one sender
     *
     * @return HasOne
     */
    public function sender(): HasOne
    {
        return $this->hasOne(Sender::class);
    }

    /**
     * User has many receivers
     *
     * @return HasMany
     */
    public function receivers(): HasMany
    {
        return $this->hasMany(Receiver::class);
    }

    /**
     * Determine whether user has sender
     *
     * @return bool
     */
    public function hasSender(): bool
    {
        return $this->sender()->exists();
    }
}
