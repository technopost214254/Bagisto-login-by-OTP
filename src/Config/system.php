<?php

return 
[
    [
        'key'  => 'emails.otp',
        'name' => 'otp-login::app.admin.configuration.email.otp.title',
        'info' => 'otp-login::app.admin.configuration.email.otp.info',
        'icon' => 'settings/store.svg',
        'sort' => 1,
    ], [
        'key'    => 'emails.otp.general',
        'name'   => 'otp-login::app.admin.configuration.email.otp.title',
        'info'   => 'otp-login::app.admin.configuration.email.otp.info',
        'sort'   => 1,
        'fields' => [
            [
                'name'  => 'emails.otp.general.admin-email',
                'title' => 'otp-login::app.admin.configuration.email.otp.admin-email',
                'type'  => 'boolean',
            ], [
                'name'  => 'emails.otp.general.customer-email',
                'title' => 'otp-login::app.admin.configuration.email.otp.customer-email',
                'type'  => 'boolean',
            ],
        ],
    ],
];