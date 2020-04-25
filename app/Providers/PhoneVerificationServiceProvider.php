<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PhoneVerificationService;
use App\Services\NexmoPhoneVerificationService;

class PhoneVerificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PhoneVerificationService::class, function ($app) {
            // TODO support for other providers, based on env
            return new NexmoPhoneVerificationService(
                config('services.nexmo.key'),
                config('services.nexmo.secret')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
