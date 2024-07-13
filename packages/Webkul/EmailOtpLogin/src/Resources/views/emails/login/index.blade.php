<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@lang('opt-login::app.email.title')</title>
    </head>
    <body>
        <div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
            <div style="margin:50px auto;width:70%;padding:20px 0">
                <div style="border-bottom:1px solid #eee">
                    <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">
                        @lang('opt-login::app.email.brand-title')
                    </a>
                </div>

                <p style="font-size:1.1em">Hi, {{ $admin->name }}</p>

                <p>
                    @lang('opt-login::app.email.description')
                </p>

                <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">
                    {{ $admin->otp }}
                </h2>

                <p style="font-size:0.9em;">
                    @lang('opt-login::app.email.thanks')
                </p>
            </div>
        </div>
    </body>
</html>