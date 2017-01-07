<?php

namespace RummyKhan\XLog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use RummyKhan\XLog\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;

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
        if ( !in_array(env('APP_ENV'), config('xlog.ignore_environments')) )
            $this->logAccess($request);

        $response = $next($request);

        // check if current app environments not exist in ignore_environments in xlog config.
        if ( !in_array(env('APP_ENV'), config('xlog.ignore_environments')) )
            $this->logResponse($response);

        return $response;
    }


    /**
     * Log Access detail to Database
     *
     * @param Request $request
     * @return void
     */
    private function logAccess(Request $request)
    {
        $this->log = new \RummyKhan\XLog\Models\Log();
        $this->log->fill(Helper::getRequestDetail($request));
        $this->log->save();
    }


    /**
     * Log response to database.
     *
     * @param Response $response
     * @return void
     */
    private function logResponse(Response $response)
    {
        $this->log->update(Helper::getResponseDetail($response));
    }
}
