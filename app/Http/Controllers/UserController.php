<?php
/**
 * Created by PhpStorm.
 * User: jiangxianli
 * Date: 16-10-24
 * Time: 上午12:17
 */

namespace App\Http\Controllers;


use App\Factory\UserFactory;
use App\Helper\DuoShuoClient;
use App\Module\ShortVideoModule;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function getLogin(Request $request)
    {
        $response = DuoShuoClient::getAccessToken($request->get('code'));

        $user = UserFactory::userModel()->where(['duo_shuo_id' => $response['user_id']])->first();
        if (!$user) {
            $user_info = DuoShuoClient::getUserInfo($response['user_id']);

            $arr  = [
                'nick_name'     => $user_info['name'],
                'image_url'     => $user_info['avatar_url'],
                'duo_shuo_id'   => $user_info['user_id'],
                'duo_shuo_info' => json_encode($user_info),
            ];
            $user = UserFactory::createUser($arr);
        }

        \Auth::login($user);

        return redirect('/');


    }

    public function getLogout(Request $request)
    {

    }
}