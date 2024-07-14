<?php

namespace Webkul\EmailOtpLogin\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Webkul\EmailOtpLogin\Providers\ModuleServiceProvider;

class EmailOtpLoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        Route::middleware('web')->group(__DIR__.'/../Routes/web.php');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'otp-login');
        
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'otp-login');
        
        $this->app->register(ModuleServiceProvider::class);
    }
}
