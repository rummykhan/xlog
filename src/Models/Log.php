<?php

namespace RummyKhan\XLog\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'id', 'title', 'page', 'url', 'response_code', 'session_id', 'ip', 'country', 'city',
        'browser', 'browser_version', 'os', 'os_version', 'request_method', 'request_params',
        'user_type', 'email', 'user_id',
        'exception', 'trace', 'error_main', 'class', 'message', 'controller_action', 'is_redirect', 'redirected_to'
    ];
}
