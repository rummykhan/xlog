<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Ignore Environment
    |--------------------------------------------------------------------------
    |
    | Here you can specify as your ignore environments to X-Log, in these
    | environments it will not log the requests, e.g. local, test
    |
    */

    'ignore_environments' => [],
    'routes' => [
        'index'     => '/admin/logs', // HTTP Method is GET
        'detail'    => '/admin/logs/{id}', // HTTP Method is GET
        'delete'    => '/admin/logs/{id}' // HTTP Method is DELETE
    ]
);