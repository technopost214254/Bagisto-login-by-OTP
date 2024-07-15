<?php

return [
    'admin' => [
        'users' => [
            'sessions' => [
                'title'       => 'Sign In',
                'email'       => 'Email',
                'otp'         => 'OTP',
                're-send-otp' => 'Re-send OTP',
                'submit-btn'  => 'Submit',
                'send-otp'    => 'Send OTP',
                'login'       => 'Login',
            ],
        ],

        'session' => [
            'not-found'          => 'Email is not registered.',
            'otp-sent'           => 'OTP Sent on given Email',
            'try-again'          => 'Some Think Went Wrong to send OTP. Please Try Again',
            'otp-not-valid'      => 'OTP is not valid',
            'success'            => 'Login Successfully',
        ],

        'emails' => [
            'thanks' => 'Thanks!',

            'login' => [
                'subject'     => 'Secure Your Login with Your One-Time Password (OTP)',
                'dear'        => 'Dear :admin_name',
                'description' => 'Your One-Time Password (OTP) for logging into :brand_number admin panel is - :otp',
            ],
        ],

        'configuration' => [
            'email' => [
                'otp' => [
                    'title'          => 'OTP Login System',
                    'info'           => 'OTP shared on email. When you enter into email and you got on email.',
                    'admin-email'    => 'Enable on admin login Page',
                    'customer-email' => 'Enable on customer login Page',
                ],
            ],
        ],
    ],

    'customers' => [
        'emails' => [
            'thanks' => 'Thanks!',

            'login' => [
                'subject'     => 'Secure Your Login with Your One-Time Password (OTP)',
                'dear'        => 'Dear :customer_name',
                'description' => 'Your One-Time Password (OTP) for logging into :brand_number Customer panel - :otp',
            ],
        ],

        'session' => [
            'customer-not-found' => 'Customer is not registered or not active. please contact to admistactive.',
            'otp-sent'           => 'OTP Sent on given Email',
            'try-again'          => 'Some Think Went Wrong to send OTP. Please Try Again',
            'otp-not-valid'      => 'OTP is not valid',
            'success'            => 'Login Successfully',
        ],

        'login-form' => [
            'bagisto'             => 'Bagisto',
            'button-title'        => 'Sign In',
            'create-your-account' => 'Create your account',
            'email'               => 'Email',
            'form-login-text'     => 'If you have an account, sign in with your email address.',
            'new-customer'        => 'New customer?',
            'page-title'          => 'Customer Login',
            'show-otp'            => 'Show OTP',
            'sign-in'             => 'Sign In',
            'verify-first'        => 'Verify your email account first.',
            'otp'                 => 'OTP',
            'otp-title'           => 'Send OTP',
            're-send-otp'         => 'Re-send OTP',
            'footer'              => 'All rights reserved.',
        ],
    ],
];
