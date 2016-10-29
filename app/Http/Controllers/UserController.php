<?php
namespace App\Http\Controllers;

use App\Module\ShortVideoModule;
use Illuminate\Http\Request;

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
     * 观看列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author  jiangxianli
     * @created_at 2016-10-27 18:57:29
     */
    public function postWatchList(Request $request)
    {
        $in_items     = $request->get('in_items', []);
        $not_in_items = $request->get('not_in_items', []);

        $items = ShortVideoModule::getWatchList($not_in_items, $in_items, 5);

        //视频列表渲染
        $view = view('short-video._items', compact('items'))->render();

        $items         = $items->toArray();
        $items['view'] = $view;
        return $items;
    }

    /**
     * 观看历史页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author  jiangxianli
     * @created_at 2016-10-29 13:46:30
     */
    public function getWatchHistoryPage()
    {
        return view('user.watch-history');
    }
}