<?php

use Illuminate\Support\Facades\Route;
use Webkul\EmailOtpLogin\Http\Controllers\Customer\SessionController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function () {

    Route::prefix('customer')->group(function () {
        /**
         * Login routes.
         */
        Route::controller(SessionController::class)->prefix('login')->group(function () {
            Route::get('', 'index')->name('shop.customer.session.index');

            Route::post('', 'store')->name('shop.customer.session.create');

            Route::post('otpVerify', 'otpVerify')->name('shop.customer.session.verify-otp');
        });

        /**
         * Logout.
         */
        Route::delete('logout', [SessionController::class, 'destroy'])->name('shop.customer.session.destroy');
    });
});
