<?php

namespace RummyKhan\XLog\Helpers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Torann\GeoIP\GeoIPFacade;

class Helper
{

    /**
     * Get public IP from the ip and X-FORWARDED-FOR
     * It actually compare the both ips and give you the public amongst them.
     *
     * @param $ip
     * @param $x_forwarded_for
     * @return mixed|null
     */
    public static function getPublicIp($ip, $x_forwarded_for){

        $x_forwarded_for = static::getClientIpFromXFF($x_forwarded_for);

        if ( static::isValidPublicIPAddress($ip) )
            return $ip;

        return $x_forwarded_for;
    }

    /**
     * Checks if the ip address is a valid ip address.
     *
     * @param $ip
     * @return mixed
     */
    public static function isValidIPAddress($ip){
        return filter_var( $ip, FILTER_VALIDATE_IP );
    }

    /**
     * Checks if IP address is valid public ip address
     *
     * @param $ip
     * @return mixed
     */
    public static function isValidPublicIPAddress($ip){
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * Get client ip from X-FORWARDED-FOR header, because this is a comma separated array sometime.
     *
     * @param $x_forwarded_for
     * @return mixed|null
     */
    public static function getClientIpFromXFF($x_forwarded_for)
    {
        // if single proxy is used only..
        if ( static::isValidIPAddress( $x_forwarded_for ) )
            return $x_forwarded_for;

        // In case client used multiple proxies. SEE https://tools.ietf.org/html/rfc7239
        $exploded = explode(' ', trim($x_forwarded_for));

        if ( static::isValidIPAddress($exploded[0]) )
            return static::isValidIPAddress($exploded);

        return '';
    }

    /**
     * Get Title from the response.
     *
     * @param $content
     * @return string
     */
    public static function getTitle($content)
    {
        return preg_match('!<title>(.*?)</title>!i', $content, $matches) ? $matches[1] : '';
    }

    /**
     * Get Detail from the request.
     *
     * @param Request $request
     * @return array
     */
    public static function getRequestDetail(Request $request)
    {
        $log                        = [];
        $log['user_type']             = 'guest';

        if ( Auth::guard(null)->check() ){
            $user                     = Auth::user();
            $log['email']             =  $user->email;
            $log['user_id']           =  $user->getAuthIdentifier();
        }

        $log['url']                   = $request->url();

        $log['session_id']            = Session::getId();
        $log['ip']                    = Helper::getPublicIp( $request->ip(), array_get($_SERVER, 'HTTP_X_FORWARDED_FOR', '') );

        $agent = new Agent();

        $log['browser']               = $agent->browser();
        $log['browser_version']       = $agent->version($agent->browser());

        $platform = '';
        if ( $agent->isRobot() )
            $platform               = $agent->robot();

        if ( $agent->isDesktop() )
            $platform               = $agent->platform();

        if ( $agent->isPhone() )
            $platform               = $agent->device();

        $log['os']                    =   $platform;
        $log['os_version']            =   $agent->version($platform);

        $location                   = GeoIPFacade::getLocation($log['ip']);

        if(isset($location['country']))
            $log['country']           = $location['country'];

        if(isset($location['city']))
            $log['city']            = $location['city'];

        $log['request_method']      = $request->method();
        $log['request_params']      = json_encode($request->all());

        return $log;
    }


    public static function getResponseDetail($response)
    {
        $log                        = [];
        $log['title']               = Helper::getTitle($response->getContent());
        $log['response_code']       = $response->getStatusCode();

        if( isset($response->exception) && !is_null($response->exception) ) {
            $log['exception']       = true;
            $log['trace']           = str_replace("\n", '<br>', $response->exception->getTraceAsString());
            $log['error_main']      = 'Error in FILE [' . $response->exception->getFile() . '] at LINE # [' . $response->exception->getLine() . ']';
            $log['class']           = get_class($response->exception);
            $log['message']         = $response->exception->getMessage();
        }

        $log['controller_action']   = null;
        if( is_object( Route::getCurrentRoute() ) )
            $log['controller_action'] = Route::getCurrentRoute()->getActionName();

        $log['is_redirect']         =   false;
        if( $response->isRedirection() ) {
            $log['is_redirect']     =   true;
            $log['redirected_to']   =   $response->getTargetUrl();
        }

        return $log;
    }
}