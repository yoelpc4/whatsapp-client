<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::unguard();

        JsonResource::withoutWrapping();

        // uncomment these lines to debugging sql
//        if (! $this->app->environment('production')) {
//            \DB::listen(function (\Illuminate\Database\Events\QueryExecuted $query) {
//                $sql = $query->sql;
//
//                $bindings = implode(', ', $query->bindings);
//
//                $time = $query->time;
//
//                \Log::channel('sql')->info("\nSQL: {$sql}\nBindings: {$bindings}\nTime: {$time}\n\n");
//            });
//        }
    }
}
