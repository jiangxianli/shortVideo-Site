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

        $response = CURL::post($url, [
            'code'      => $code,
            'client_id' => 'jiangxianli'
        ]);
        $response = json_decode($response, true);

        return $response;

    }


    public static function getUserInfo($user_id)
    {
        $url      = 'http://api.duoshuo.com/users/profile.json?user_id=' . $user_id;
        $response = CURL::get($url);
        $response = (array)json_decode($response, true);
        if ($response && $response['code'] == 0) {

            return $response['response'];
        }

        return $response;


    }


}