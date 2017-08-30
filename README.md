X-Log
=====

[![Latest Stable Version](https://img.shields.io/badge/packagist-V%203.0.0-blue.svg)](https://packagist.org/packages/rummykhan/xlog)

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

Add Middleware
--------------
Add `XLogMiddleWare` to your `app\Http\Kernel.php` as a web middleware group:

```php
\RummyKhan\XLog\Http\Middleware\XLogMiddleware::class,
```

Migrate Log Table ( You don't have to migrate if your database is mongodb.)
---------------------------------------------------------------------------
Migrate Log Table migration:

```bash
php artisan migrate
```

 Configure your application logging behavior
--------------------------------------------

The `php artisan vendor:publish` will publish `Log table migration` into migrations folder, `geoip.php` and `xlog.php` in config folder of you laravel installation.

#### Logging Environments

In `xlog.php` you may specify your `igonore_environments` as an array, In these environment it will not log any request or response e.g.

```php
'ignore_environments' => ['local', 'test'],
```

#### Set Database Type

In `xlog.php` you may specify your `db_type` as string. Since laravel supported databases (mysql, sqlite, pgsql) behaves differently than laravel not supported databases, For that purpose I'm using a `ProxyModel` Which switch the `Eloquent Mode` based on database type.
E.g. For any laravel supported database you can leave it blank, For mongodb you can set it to 'mongo'.

```php
'db_type' => 'mongodb'
```
Supported database types are (sqlite, mysql, pgsql, mongodb).

#### DB Connection

In `xlog.php` you may specify your `connection` as string. This connection will be used to save the logs. (By default it uses application connection)
```php
'connection' => env('DB_CONNECTION')
```
Supported database types are (sqlite, mysql, pgsql, mongodb).

#### DB Table
In `xlog.php` you may specify the table_name for you logs.
```php
'table' => 'logs'
```

#### Log Display Routes
In `xlog.php` you may specify your `routes`. For now there are only three routes. 
1. Index: where you can see the logs in tabular format using laravel pagination.
2. Detail: Where you can see the logs detail.
3. Delete: You can delete a log.
    
( You may specify you own routes and controllers in case you want to. All you have to do is Call the RummyKhan\XLog\Models\Log Model to get the logs.)
```php
'routes' => [
    'index'  => [ 'route' => '/admin/logs',      'action' => 'XLogController@index'],        // HTTP Method is GET
    'detail' => [ 'route' => '/admin/logs/{id}', 'action' => 'XLogController@detail'],       // HTTP Method is GET
    'delete' => [ 'route' => '/admin/logs/{id}', 'action' => 'XLogController@delete']        // HTTP Method is DELETE
],
```
When changing routes, don't change the wildcard `{id}` from the routes.

#### Log Middleware
In `xlog.php` you can specify the middleware for you log routes. By default middleware is set to auth.
```php
'middleware' => ['auth']
```

## MIT Liscense
Laravel rummykhan/xlog is licensed under [The MIT License (MIT)](LICENSE).
