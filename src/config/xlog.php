<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | X-log Ignore Environment
    |--------------------------------------------------------------------------
    |
    | Here you can specify as your ignore environments to X-Log, in these
    | environments it will not log the requests, e.g. local, test
    |
    */

    'ignore_environments' => [],
    /*
    |--------------------------------------------------------------------------
    | X-log Routes
    |--------------------------------------------------------------------------
    |
    | Here you can specify your routes for xlog, for now there are three basic routes
    | 1. Index where you can see list of all the logs..
    | 2. Here you can see the detail of a single log..
    | 3. If you want to delete a single log.
    |
    */
    'routes' => [
        'index'     => '/admin/logs', // HTTP Method is GET
        'detail'    => '/admin/logs/{id}', // HTTP Method is GET
        'delete'    => '/admin/logs/{id}' // HTTP Method is DELETE
    ],

    /*
    |--------------------------------------------------------------------------
    | X-log Middleware protection
    |--------------------------------------------------------------------------
    |
    | Here you can specify your middleware to which these logs should be accessible.
    | e.g. if this route should be visible to admin only.
    | add the 'admin' to middleware array.
    | by default it is set to auth, which is out of box middleware for laravel auth system.
    |
    */
    'middleware' => ['auth']
);