<?php

namespace App\Providers;

use App\Services\NexmoPhoneVerificationService;
use App\Services\PhoneVerificationService;
use Illuminate\Support\ServiceProvider;

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
            // TODO support for twilio or other providers
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
