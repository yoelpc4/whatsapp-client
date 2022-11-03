<?php

namespace App\Providers;

use App\Models\Receiver;
use App\Models\Sender;
use App\Policies\ReceiverPolicy;
use App\Policies\SenderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Receiver::class => ReceiverPolicy::class,
        Sender::class   => SenderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
