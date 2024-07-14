## Installation without composer:

- This package is for customer and admin login via OTP sent to email. Create an `EmailOtpLogin` folder under the `package/Webkul` folder and copy all file under that folder. also this package made for bagisto v2.2.0

Bagisto: v2.2.0

- Goto config/app.php file and add following line under 'providers'

```
Webkul\EmailOtpLogin\Providers\EmailOtpLoginServiceProvider::class,
```

- Goto composer.json file and add following line under 'psr-4'

```
"Webkul\\EmailOtpLogin\\": "packages/Webkul/EmailOtpLogin/src"
```

- Goto config/bagisto-vite.php file and add following line under 'psr-4'

```
'otp-login' => [
    'hot_file'                 => 'admin-email-otp-vite.hot',
    'build_directory'          => 'themes/admin-email-otp-login/default/build',
    'package_assets_directory' => 'src/Resources/assets',
],
```

- Run these commands below to complete the setup

```
composer dump-autoload
```

```
php artisan migrate
php artisan route:cache
```

```
php artisan vendor:publish

-> Press 0 and then press enter to publish all assets and configurations.
```