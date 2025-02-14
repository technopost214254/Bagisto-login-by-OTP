<?php

use Illuminate\Support\Facades\Route;
use Webkul\EmailOtpLogin\Http\Controllers\Admin\AdminLoginController;
use Webkul\EmailOtpLogin\Http\Controllers\Admin\SessionController;

/**
 * Auth routes.
 */
Route::group(['prefix' => config('app.admin_url')], function () {
    /**
     * Redirect route.
     */     
    Route::get('/', [AdminLoginController::class, 'index'])->name('admin.session.create');

    Route::controller(SessionController::class)->prefix('login')->group(function () {
        /**
         * Login routes.
         */
        Route::get('', 'index')->name('admin.otp.session.create');
        
        /**
         * Login post route to admin auth controller.
         */
        Route::post('otp-send', 'store')->name('admin.otp.session.store');

        /**
         * Login with OTP verify
         */
        Route::post('verifying', 'otpVerify')->name('admin.otp.session.verify-otp');

        /**
         * Logout
         */
        Route::delete('logout', 'destroy')->name('admin.session.destroy');
    });
});
