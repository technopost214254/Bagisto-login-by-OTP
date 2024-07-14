<?php

namespace Webkul\EmailOtpLogin\Http\Controllers\Customer;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cookie;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\EmailOtpLogin\Mail\Customer\OtpNotification;
use Webkul\Customer\Repositories\CustomerRepository;

class SessionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository
    ) {
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->guard('customer')->check()) {
            return redirect()->route('shop.home.index');
        }

        return view('otp-login::customers.login.sign-in');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(): JsonResponse
    {
        $this->validate(request(), [
            'email'  => 'required',
        ]);

        $customer = $this->customerRepository->where([
            'email'  => request()->input('email'),
            'status' => 1,
        ])->first();

        if (! $customer) {
            return new JsonResponse([
                'message' => trans('otp-login::app.customers.session.customer-not-found'),
            ], 500);
        }

        // OTP shared
        if($this->sentOtpOnMail($customer)) {
            return new JsonResponse([
                'message' => trans('otp-login::app.customers.session.otp-sent'),
            ], 200);
        }

        // Otp Not Send
        return new JsonResponse([
            'message' => trans('otp-login::app.customers.session.try-again'),
        ], 500);
    }

    /**
     * OTP Sent On Register mail
     * 
     * @param mixed $admin
     */
    public function sentOtpOnMail($customer) 
    {
        try {
            $otp = rand(100000, 999999);

            $customer->otp = $otp;
            $customer->save();

            Mail::queue( new OtpNotification($customer));

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return false;
    }

    /**
     * Verify OTP and Login
     */
    public function otpVerify()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'otp'   => 'required|numeric'
        ]);

        $customer = $this->customerRepository->where([
            'email' => request()->input('email'),
            'otp'   => request()->input('otp'),
        ])->first();

        if(! $customer) {
            return new JsonResponse([
                'message' => trans('otp-login::app.customers.session.otp-not-valid'),
            ], 500);
        }

        if (auth()->guard('customer')->loginUsingId($customer->id, false)) {
            if (! auth()->guard('customer')->user()->is_verified) {
                session()->flash('info', trans('otp-login::app.customers.login-form.verify-first'));

                Cookie::queue(Cookie::make('enable-resend', 'true', 1));

                Cookie::queue(Cookie::make('email-for-resend', request()->input('email'), 1));

                auth()->guard('customer')->logout();

                return new JsonResponse([
                    'redirect' => route('shop.customer.session.index'),
                ], 200);
            }

            /**
             * Event passed to prepare cart after login.
             */
            Event::dispatch('customer.after.login', auth()->guard()->user());

            $route = route('shop.home.index');

            if (core()->getConfigData('customer.settings.login_options.redirected_to_page') == 'account') {
                $route = route('shop.customers.account.profile.index');
            }

            return new JsonResponse([
                'message'  => trans('otp-login::app.customers.session.success'),
                'redirect' => $route,
            ], 200);
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = auth()->guard('customer')->user()->id;

        auth()->guard('customer')->logout();

        Event::dispatch('customer.after.logout', $id);

        return redirect()->route('shop.home.index');
    }
}
