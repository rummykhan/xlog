<?php

namespace RummyKhan\XLog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use RummyKhan\XLog\Helpers\Helper;
use RummyKhan\XLog\Models\Log;
use Torann\GeoIP\GeoIPFacade;
use Jenssegers\Agent\Agent;

class LoggingMiddleware
{

    private $log_info;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * Breakdown the access log and response, because there are few packages where
         * package itself handle the response e.g. Maatwebsite Excel, in that case the
         * log code will never execute.
         */

        // check if current app environments not exist in ignore_environments in xlog config.
        if ( !in_array(env('APP_ENV'), Config::get('xlog.ignore_environments')) )
            $this->logAccess($request);

        $response = $next($request);

        // check if current app environments not exist in ignore_environments in xlog config.
        if ( !in_array(env('APP_ENV'), Config::get('xlog.ignore_environments')) )
            $this->logResponse($response);

        return $response;
    }


    /**
     * @param Request $request
     */
    private function logAccess(Request $request)
    {
        $this->log_info                       = new Log();
        $this->log_info['user_type']          = 'guest';

        if ( Auth::guard(null)->check() ){
            $this->log_info['user_type']      = 'Admin';
            $this->log_info['user_email']     = Auth::user()->email;
            $this->log_info['user_id']        = Auth::user()->id;
        }

        $this->log_info['page']               = $request->path();
        $this->log_info['url']                = $request->url();

        $this->log_info['session_id']         = Session::getId();
        $this->log_info['ip']                 = Helper::getPublicIp( $request->ip(), Helper::tryGetValue($_SERVER, 'HTTP_X_FORWARDED_FOR') );

        $agent = new Agent();

        $this->log_info['browser']            = $agent->browser();
        $this->log_info['browser_version']    = $agent->version($agent->browser());

        $platform = '';
        if ( $agent->isRobot() )
            $platform                         = $agent->robot();

        if ( $agent->isDesktop() )
            $platform                         = $agent->platform();

        if ( $agent->isPhone() )
            $platform                         = $agent->device();

        $this->log_info['os']                 =   $platform;
        $this->log_info['os_version']         =   $agent->version($platform);

        $location                           = GeoIPFacade::getLocation($this->log_info['ip']);

        if(isset($location['country']))
            $this->log_info['country']        = $location['country'];

        if(isset($location['city']))
            $this->log_info['city']           = $location['city'];

        $this->log_info['request_method']     = $request->method();
        $this->log_info['request_params']     = json_encode($request->all());

        $this->log_info->save();
    }


    /**
     * @param Response $response
     */
    private function logResponse(Response $response)
    {
        $this->log_info['title']              = Helper::getTitle($response->getContent());
        $this->log_info['response_code']      = $response->getStatusCode();

        if( isset($response->exception) && !is_null($response->exception) ) {
            $this->log_info['exception']      = true;
            $this->log_info['trace']          = str_replace("\n", '<br>', $response->exception->getTraceAsString());
            $this->log_info['error_main']     = 'Error in FILE [' . $response->exception->getFile() . '] at LINE # [' . $response->exception->getLine() . ']';
            $this->log_info['class']          = get_class($response->exception);
            $this->log_info['message']        = $response->exception->getMessage();
        }

        $this->log_info['controller_action']  = null;
        if( is_object( Route::getCurrentRoute() ) )
            $this->log_info['controller_action'] = Route::getCurrentRoute()->getActionName();

        $this->log_info['is_redirect']        =   false;
        if( $response->isRedirection() ) {
            $this->log_info['is_redirect']    =   true;
            $this->log_info['redirected_to']  =   $response->getTargetUrl();
        }

        $this->log_info->save();
    }
}
