<?php
/**
 * Created by PhpStorm.
 * User: jiangxianli
 * Date: 16-10-24
 * Time: 上午12:17
 */

namespace App\Http\Controllers;


use App\Helper\DuoShuoClient;
use App\Module\ShortVideoModule;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function getLogin(Request $request){

        DuoShuoClient::getAccessToken($request->get('code'));

    }

    public function getLogout(Request $request){

    }
}