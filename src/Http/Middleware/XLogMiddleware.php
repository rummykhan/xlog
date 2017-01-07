<?php

namespace RummyKhan\XLog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use RummyKhan\XLog\Helpers\Helper;
use RummyKhan\XLog\Models\Log;
use Symfony\Component\HttpFoundation\Response;
use Torann\GeoIP\GeoIPFacade;
use Jenssegers\Agent\Agent;

class XLogMiddleware
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
        $log                        = new Log();
        

        $log->save();
    }


    /**
     * @param Response $response
     */
    private function logResponse(Response $response)
    {
        $log['title']              = Helper::getTitle($response->getContent());
        $log['response_code']      = $response->getStatusCode();

        if( isset($response->exception) && !is_null($response->exception) ) {
            $log['exception']      = true;
            $log['trace']          = str_replace("\n", '<br>', $response->exception->getTraceAsString());
            $log['error_main']     = 'Error in FILE [' . $response->exception->getFile() . '] at LINE # [' . $response->exception->getLine() . ']';
            $log['class']          = get_class($response->exception);
            $log['message']        = $response->exception->getMessage();
        }

        $log['controller_action']  = null;
        if( is_object( Route::getCurrentRoute() ) )
            $log['controller_action'] = Route::getCurrentRoute()->getActionName();

        $log['is_redirect']        =   false;
        if( $response->isRedirection() ) {
            $log['is_redirect']    =   true;
            $log['redirected_to']  =   $response->getTargetUrl();
        }

        $log->save();
    }
}
