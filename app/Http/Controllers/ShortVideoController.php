<?php
namespace App\Http\Controllers;

use App\Module\ShortVideoModule;
use Illuminate\Http\Request;

class ShortVideoController extends Controller
{
    /**
     * 视频列表
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @author  jiangxianli
     * @created_at 2016-10-27 18:35:05
     */
    public function postNormalList(Request $request)
    {
        //排除页面上的ID
        $not_in_items = $request->get('not_in_items', []);
        //视频列表
        $items = ShortVideoModule::getNormalList($not_in_items, 20);
        //视频列表渲染
        $view = view('short-video._items', compact('items'))->render();

        $items         = $items->toArray();
        $items['view'] = $view;
        return $items;
    }

    /**
     * 视频详情
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author  jiangxianli
     * @created_at 2016-10-27 18:33:58
     */
    public function getDetail(Request $request, $id)
    {
        $item = ShortVideoModule::getNormalDetail($id);

        return view('short-video.detail', compact('item'));
    }

    /**
     * 视频播放次数统计
     *
     * @param Request $request
     * @param $id
     * @author  jiangxianli
     * @created_at 2016-10-29 13:46:05
     */
    public function postClickCount(Request $request, $id)
    {

        ShortVideoModule::incrementClickCount($id);

    }
}