<?php
namespace App\Http\Controllers;

use App\Module\TagModule;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * 登录页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author  jiangxianli
     * @created_at 2016-10-27 18:36:18
     */
    public function getTagPage()
    {
        return view('tag.list');
    }

    /**
     * 标签列表
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @author  jiangxianli
     * @created_at 2016-10-29 13:30:07
     */
    public function postTagList(Request $request)
    {

        $not_in_items = $request->get('not_in_items', []);

        $tags = TagModule::getTagList($not_in_items);

        $view = view('tag._item', compact('tags'))->render();

        $tags         = $tags->toArray();
        $tags['view'] = $view;

        return $tags;
    }

    /**
     * 标签详情
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author  jiangxianli
     * @created_at 2016-10-29 13:31:02
     */
    public function getTagDetail(Request $request, $id)
    {

        $tag = TagModule::getTagDetail($id);

        return view('tag.index', compact('tag'));

    }

    /**
     * 标签视频列表
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @author  jiangxianli
     * @created_at 2016-10-29 13:28:31
     */
    public function postTagVideoList(Request $request, $id)
    {
        $not_in_items = $request->get('not_in_items', []);

        $items = TagModule::getTagVideoList($not_in_items, $id);

        //视频列表渲染
        $view = view('short-video._items', compact('items'))->render();

        $items         = $items->toArray();
        $items['view'] = $view;
        return $items;
    }
}