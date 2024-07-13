## Installation without composer:

- Unzip the respective extension zip and then merge "packages" and "storage" folders into project root directory.

- Goto config/app.php file and add following line under 'providers'

```
Webkul\EmailOtpLogin\Providers\EmailOtpLoginServiceProvider::class,
```

- Goto composer.json file and add following line under 'psr-4'

```
"Webkul\\EmailOtpLogin\\": "packages/Webkul/EmailOtpLogin/src"
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