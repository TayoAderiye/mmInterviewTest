<?php

namespace App\Providers;

use App\Services\Implementations\AuthService;
use App\Services\Implementations\EMailService;
use App\Services\Implementations\WalletService;
use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IEMailService;
use App\Services\Interfaces\IWalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IWalletService::class, WalletService::class);
        $this->app->bind(IEMailService::class, EMailService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
