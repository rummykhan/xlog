X-Log
=====

[![Latest Stable Version](https://img.shields.io/badge/packagist-v%202.0.0-blue.svg)](https://packagist.org/packages/rummykhan/xlog)

A PHP/Laravel Package to log all the requests, with the exceptions, country and city. It will help you get insight of your visitors activiy. Built on top of `torann/geoip` and `jenssegers/agent`

Installation
------------

Install using composer:

```bash
composer require rummykhan/xlog
```

Add Service Providers
---------------------

Add these two service provider in `app/config/app.php`:

```php
\Torann\GeoIP\GeoIPServiceProvider::class,
RummyKhan\XLog\XLogServiceProvider::class,
```

Publish Configuration
---------------------

Publish the configuration using command:

```bash
php artisan vendor:publish
```

Update geoip database
---------------------

Update geoip database using command:

```bash
php artisan geoip:update
```

 Configure your application logging behavior
--------------------------------------------

    #### Configure Logging Environments
    
    The `php artisan vendor:publish` will publish `Log table migration` into migrations folder, `geoip.php` and `xlog.php` in config folder of you laravel installation.
    In `xlog.php` you can specify your `igonore_environments` as an array e.g.
    
    ```php
    'ignore_environments' => ['local', 'test'],
    ```
    
    #### Configure Logging Connection
    
    The `php artisan vendor:publish` will publish `xlog.php` in config folder of you laravel installation.
    In `xlog.php` you can specify your `connection` as string. This will be the connection where xlog will save all the logs of your application.
    
    ```php
    'connection' => 'mysql',
    ```
    By default it uses application default connection.



Migrate Log Table (if your connection is mysql)
-----------------------------------------------

Create Log Table using command:

```bash
php artisan migrate
```

Add Middleware
--------------

Add `LogginMiddleWare` to your `app\Http\Kernel.php` as a web middleware group:

```php
\RummyKhan\XLog\Http\Middleware\XLogMiddleware::class,
```


## MIT Liscense

Laravel rummykhan/xlog is licensed under [The MIT License (MIT)](LICENSE).
