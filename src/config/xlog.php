<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | X-log Ignore Environment
    |--------------------------------------------------------------------------
    |
    | Here you may specify as your ignore environments to X-Log, in these
    | environments it will not log the requests, e.g. local, test
    |
    */

    'ignore_environments' => [],
    /*
    |--------------------------------------------------------------------------
    | X-log Routes
    |--------------------------------------------------------------------------
    |
    | Here you may specify your routes for xlog, for now there are three basic routes
    | 1. Index where you can see list of all the logs..
    | 2. Here you can see the detail of a single log..
    | 3. If you want to delete a single log.
    |
    | You may write your own routes and controllers, All you need is to use Log Model of rummykhan/xlog package.
    */
    'routes' => [
        'index'     => [ 'route' => '/admin/logs',      'action' => 'XLogController@index'],        // HTTP Method is GET
        'detail'    => [ 'route' => '/admin/logs/{id}', 'action' => 'XLogController@detail'],       // HTTP Method is GET
        'delete'    => [ 'route' => '/admin/logs/{id}', 'action' => 'XLogController@delete']        // HTTP Method is DELETE
    ],

    /*
    |--------------------------------------------------------------------------
    | X-log Middleware protection
    |--------------------------------------------------------------------------
    |
    | Here you may specify your middleware to which these logs should be accessible.
    | e.g. if this route should be visible to admin only.
    | add the 'admin' to middleware array.
    | by default it is set to auth, which is out of box middleware for laravel auth system.
    |
    */
    'middleware' => ['auth'],

    /*
    |--------------------------------------------------------------------------
    | X-log Database Type
    |--------------------------------------------------------------------------
    |
    | Here you may specify type of database.
    | Possible choices are:
    |       1. mongo (For Mongodb)
    |       2. You can leave it blank if the database type is supported by laravel (e.g. sqlite, mysql and pgsql etc.).
    */
    'db_type' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | X-log Database Connection
    |--------------------------------------------------------------------------
    |
    | Here you may specify your database connection for logs.
    | e.g. your active connection for your application is mysql
    | but for logs you want to use any other connection, you can specify your connection here.
    | supported connection are (sqlite, mysql, pgsql, mongodb ), default connection is mysql.
    |
    */
    'connection' => env('DB_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | X-log Database Table / Collection
    |--------------------------------------------------------------------------
    |
    | Here you may specify your database table for logs.
    |
    */
    'table' => 'logs'
);