<?php

namespace RummyKhan\XLog\Models;

if( config('xlog.connection') === 'mongodb' && class_exists('Jenssegers\Mongodb\Eloquent\Model') ){
    class Log extends \Jenssegers\Mongodb\Eloquent\Model
    {

        protected $collection = 'logs';

        protected $fillable = [
            'id', 'title', 'url', 'response_code', 'session_id', 'ip', 'country', 'city',
            'browser', 'browser_version', 'os', 'os_version', 'request_method', 'request_params',
            'email', 'user_id',
            'exception', 'trace', 'error_main', 'class', 'message', 'controller_action', 'is_redirect', 'redirected_to'
        ];
        protected $attributes = [
            'redirected_to' => null,
            'email' => null,
            'user_id' => null
        ];
    }

}else{
    class Log extends \Illuminate\Database\Eloquent\Model
    {

        protected $collection = 'logs';

        protected $fillable = [
            'id', 'title', 'url', 'response_code', 'session_id', 'ip', 'country', 'city',
            'browser', 'browser_version', 'os', 'os_version', 'request_method', 'request_params',
            'email', 'user_id',
            'exception', 'trace', 'error_main', 'class', 'message', 'controller_action', 'is_redirect', 'redirected_to'
        ];

        protected $attributes = [
            'redirected_to' => null,
            'email' => null,
            'user_id' => null
        ];
    }
}


