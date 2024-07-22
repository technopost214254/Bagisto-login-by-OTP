<?php

namespace Webkul\EmailOtpLogin\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Webkul\EmailOtpLogin\Http\Controllers\Controller;
use Webkul\User\Repositories\AdminRepository;
use Webkul\EmailOtpLogin\Mail\Admin\OtpNotification;

class SessionController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected AdminRepository $adminRepository) 
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard.index');
        }

        if (strpos(url()->previous(), 'admin') !== false) {
            $intendedUrl = url()->previous();
        } else {
            $intendedUrl = route('admin.dashboard.index');
        }

        session()->put('url.intended', $intendedUrl);

        return view('otp-login::admin.users.sessions.create');
    }

    /**
     * Send OTP.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(): JsonResponse
    {
        $this->validate(request(), [
            'email'  => 'required',
        ]);

        $admin = $this->adminRepository->findOneByField('email', request()->input('email'));

        // Customer Not Found
        if(! $admin) {
            return new JsonResponse([
                'message' => trans('otp-login::app.admin.session.not-found'),
            ], 500);
        }

        // OTP shared
        if($this->sentOtpOnMail($admin)) {
            return new JsonResponse([
                'message' => trans('otp-login::app.admin.session.otp-sent'),
            ], 200);
        }

        // Otp Not Send
        return new JsonResponse([
            'message' => trans('otp-login::app.admin.session.try-again'),
        ], 500);
    }

    /**
     * Resend OTP
     * 
     * @param mixed $admin
     */
    public function sentOtpOnMail($admin) 
    {
        try {
            $otp = rand(100000, 999999);

            $admin->otp = $otp;
            $admin->save();

            Mail::queue( new OtpNotification($admin));

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

        $admin = $this->adminRepository->where([
            'email' => request()->input('email'),
            'otp'   => request()->input('otp'),
        ])->first();

        if(! $admin) {
            return new JsonResponse([
                'message' => trans('otp-login::app.admin.session.otp-not-valid'),
            ], 500);
        }

        if (auth()->guard('admin')->loginUsingId($admin->id, false)) {
            return new JsonResponse([
                'message'  => trans('otp-login::app.admin.session.success'),
                'redirect' => route('admin.dashboard.index'),
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
        auth()->guard('admin')->logout();

        return redirect()->route('admin.otp.session.create');
    }
}