<?php

namespace Webkul\EmailOtpLogin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\EmailOtpLogin\Providers\ModuleServiceProvider;

class EmailOtpLoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        if(core()->getConfigData('emails.otp.general.emails.otp.general.admin-email')) {
            Route::middleware('web')->group(__DIR__.'/../Routes/admin-routes.php');
        }

        if(core()->getConfigData('emails.otp.general.emails.otp.general.customer-email')) {
            Route::middleware('web')->group(__DIR__.'/../Routes/shop-routes.php');
        }

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'otp-login');
        
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'otp-login');
        
        $this->app->register(ModuleServiceProvider::class);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php',
            'core'
        );
    }
}
