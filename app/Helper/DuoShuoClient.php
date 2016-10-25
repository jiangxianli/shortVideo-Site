<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/25
 * Time: 13:14
 */

namespace App\Helper;

use Symfony\Component\HttpKernel\Client;

class DuoShuoClient
{
    var $end_point = 'http://api.duoshuo.com/';
    var $format = 'json';
    var $userAgent;
    var $shortName;
    var $secret;
    var $jwt;
    var $accessToken;
    var $http;

    public function __construct($shortName = null, $secret = null, $jwt = null, $accessToken = null)
    {
        global $wp_version;

        $this->shortName   = $shortName;
        $this->secret      = $secret;
        $this->jwt         = $jwt;
        $this->accessToken = $accessToken;
    }

    public static function getAccessToken($code)
    {

        $url = 'http://api.duoshuo.com/oauth2/access_token';

        $reponse = CURL::post($url, [
            'code'      => $code,
            'client_id' => ''
        ]);

        \Log::info($reponse);
        return $reponse;

    }


}