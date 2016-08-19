<?php

namespace RummyKhan\XLog\Http\Middleware;

use Closure;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use RummyKhan\XLog\Helpers\Helper;
use RummyKhan\XLog\Models\Log;
use Torann\GeoIP\GeoIPFacade;
use Jenssegers\Agent\Agent;

class LoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        if ( in_array(env('APP_ENV'), Config::get('xlog.ignore_environments')) )
            return;

        $log_info                       = [];
        $log_info['user_type']          = 'guest';

        if ( Auth::guard(null)->check() ){
            $log_info['user_type']      = 'Admin';
            $log_info['user_email']     = Auth::user()->email;
            $log_info['user_id']        = Auth::user()->id;
        }

        $agent = new Agent();

        $log_info['title']              = Helper::getTitle($response->getContent());
        $log_info['page']               = $request->path();
        $log_info['url']                = $request->url();
        $log_info['response_code']      = $response->getStatusCode();
        $log_info['session_id']         = Session::getId();
        $log_info['ip']                 = Helper::getPublicIp($request->ip(), Helper::tryGetValue($_SERVER, 'HTTP_X_FORWARDED_FOR'));
        $location                       = GeoIPFacade::getLocation($log_info['ip']);

        if(isset($location['country']))
            $log_info['country']        = $location['country'];

        if(isset($location['city']))
            $log_info['city']           = $location['city'];

        $log_info['browser']            = $agent->browser();
        $log_info['browser_version']    = $agent->version($agent->browser());

        $platform = '';
        if ( $agent->isRobot() )
            $platform                   = $agent->robot();

        if ( $agent->isDesktop() )
            $platform                   = $agent->platform();

        if ( $agent->isPhone() )
            $platform                   = $agent->device();

        $log_info['os']                 =   $platform;
        $log_info['os_version']         =   $agent->version($platform);

        $log_info['request_method']     = $request->method();
        $log_info['request_params']     = json_encode($request->all());

        if( isset($response->exception) && !is_null($response->exception) ) {
            $log_info['exception']      = true;
            $log_info['trace']          = str_replace("\n", '<br>', $response->exception->getTraceAsString());
            $log_info['error_main']     = 'Error in FILE [' . $response->exception->getFile() . '] at LINE # [' . $response->exception->getLine() . ']';
            $log_info['class']          = get_class($response->exception);
            $log_info['message']        = $response->exception->getMessage();
        }

        $log_info['controller_action']  = null;
        if( is_object( Route::getCurrentRoute() ) )
            $log_info['controller_action'] = Route::getCurrentRoute()->getActionName();

        $log_info['is_redirect']        =   false;
        if( $response->isRedirection() ) {
            $log_info['is_redirect']    =   true;
            $log_info['redirected_to']  =   $response->getTargetUrl();
        }

        Log::create($log_info);
    }
}
