<?php
namespace App\Http\Controllers;

use App\Factory\UserFactory;
use App\Helper\DuoShuoClient;
use App\Module\ShortVideoModule;
use App\Module\TagModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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

    public function getTagList(Request $request)
    {

        $not_in_items = $request->get('not_in_items', []);

        $tags = TagModule::getTagList($not_in_items);

        $view = view('tag._item', compact('tags'))->render();

        $tags         = $tags->toArray();
        $tags['view'] = $view;

        return $tags;
    }

    public function getTagDetail(Request $request, $id ){

        $tag = TagModule::getTagDetail($id);

        return view('tag.index',compact('tag'));

    }


    public function getTagVideoList(Request $request, $id)
    {
        $not_in_items = $request->get('not_in_items', []);

        $items = TagModule::getTagVideoList($not_in_items, $id);

        //视频列表渲染
        $view = view('short-video._items', compact('items'))->render();

        $items         = $items->toArray();
        $items['view'] = $view;
        return $items;

        return $tags;
    }
}