<?php

namespace RummyKhan\XLog\Models;

class Log extends ProxyModel
{
    protected $fillable = [
        'id', 'title', 'url', 'response_code', 'session_id', 'ip', 'country', 'city',
        'browser', 'browser_version', 'os', 'os_version', 'request_method', 'request_params',
        'email', 'user_id',
        'exception', 'trace', 'error_main', 'class', 'message', 'controller_action', 'is_redirect', 'redirected_to'
    ];

    protected $attributes = [
        'redirected_to' => null,
        'email' => null,
        'user_id' => null,
        'title' => null,
        'response_code' => 200
    ];

    public function __construct($attributes=[])
    {
        parent::__construct($attributes);

        $this->connection = config('xlog.connection') ?: env('DB_CONNECTION');

        if( config('xlog.connection') === 'mongodb' ) {
            $this->collection = config('xlog.table') ?: 'logs';
        } else {
            $this->table = config('xlog.table') ?: 'logs';
        }
    }
}





