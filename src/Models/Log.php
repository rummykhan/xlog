<?php

namespace RummyKhan\XLog\Models;

if( config('xlog.connection') === 'mongodb' && class_exists('Jenssegers\Mongodb\Eloquent\Model') ){
    use Jenssegers\Mongodb\Eloquent\Model;

}else{
    use Illuminate\Database\Eloquent\Model;
}

class Log extends Model
{

    protected $table = 'logs';

    protected $fillable = [
        'id', 'title', 'url', 'response_code', 'session_id', 'ip', 'country', 'city',
        'browser', 'browser_version', 'os', 'os_version', 'request_method', 'request_params',
        'email', 'user_id',
        'exception', 'trace', 'error_main', 'class', 'message', 'controller_action', 'is_redirect', 'redirected_to'
    ];
}



