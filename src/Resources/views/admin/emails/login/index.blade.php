@component('otp-login::admin.emails.layout.index')
    <div style="margin-bottom: 34px;">
        <p style="font-weight: bold;font-size: 20px;color: #121A26;line-height: 24px;margin-bottom: 24px">
            @lang('otp-login::app.admin.emails.login.dear', ['admin_name' => $admin->name]), 👋
        </p>
    </div>

    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
        {!! __('otp-login::app.admin.emails.login.description', [
                'brand_number' => 'Bagisto Store',
                'otp'          => $admin->otp,
            ])
        !!}
    </p>
@endcomponent