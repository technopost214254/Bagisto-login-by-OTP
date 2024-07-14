@component('otp-login::customers.emails.layout.index')
    <div style="margin-bottom: 34px;">
        <p style="font-weight: bold;font-size: 20px;color: #121A26;line-height: 24px;margin-bottom: 24px">
            @lang('otp-login::app.customers.emails.login.dear', ['customer_name' => $customer->first_name . ' ' . $customer->last_name]), 👋
        </p>
    </div>

    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
        {!! __('otp-login::app.customers.emails.login.description', [
                'brand_number' => 'Bagisto Store',
                'otp'          => $customer->otp,
            ])
        !!}
    </p>
@endcomponent