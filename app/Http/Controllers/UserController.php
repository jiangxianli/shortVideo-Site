<?php
namespace App\Http\Controllers;

use App\Factory\UserFactory;
use App\Helper\DuoShuoClient;
use App\Module\ShortVideoModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    /**
     * 登录页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author  jiangxianli
     * @created_at 2016-10-27 18:36:18
     */
    public function getLoginPage()
    {
        return view('login');
    }

    /**
     * 用户登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author  jiangxianli
     * @created_at 2016-10-27 18:36:28
     */
    public function getLogin(Request $request)
    {
        //多说用户登录
        $response = DuoShuoClient::getAccessToken($request->get('code'));
        //查询用户信息
        $user = UserFactory::userModel()->where(['duo_shuo_id' => $response['user_id']])->first();
        if (!$user) {
            //获取多说用户信息
            $user_info = DuoShuoClient::getUserInfo($response['user_id']);
            $arr       = [
                'nick_name'     => $user_info['name'],
                'image_url'     => $user_info['avatar_url'],
                'duo_shuo_id'   => $user_info['user_id'],
                'duo_shuo_info' => json_encode($user_info),
            ];
            //创建新用户
            $user = UserFactory::createUser($arr);
        }
        //用户登录
        \Auth::login($user);

        return redirect('/');
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author  jiangxianli
     * @created_at 2016-10-27 18:38:50
     */
    public function getLogout(Request $request)
    {
        if (\Auth::check()) {
            \Auth::logout();
        }

        return redirect('/');
    }

    /**
     * 观看列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author  jiangxianli
     * @created_at 2016-10-27 18:57:29
     */
    public function getWatchList(Request $request)
    {
        $in_items = $request->get('in_items', []);
        $not_in_items = $request->get('not_in_items', []);

        $item = ShortVideoModule::getWatchList($not_in_items,$in_items, 5);

        return view('short-video.detail', compact('item'));
    }

    public function getWatchHistoryPage()
    {
        return view('user.watch-history');
    }
}