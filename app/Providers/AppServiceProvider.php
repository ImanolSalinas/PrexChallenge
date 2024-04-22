<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        //
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

       
       Passport::tokensExpireIn(Carbon::now()->addMinutes(30)); 
       Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(30)); 
       Passport::personalAccessTokensExpireIn(Carbon::now()->addMinutes(30));
       
    }
}
