<?php

namespace RummyKhan\XLog\Helpers;

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
}