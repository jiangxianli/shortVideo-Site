<?php
namespace App\Http\Controllers;

use App\Module\ShortVideoModule;
use Illuminate\Http\Request;

class ApiController extends Controller
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
    public function getNormalList(Request $request)
    {
        //排除页面上的ID
        $not_in_items = $request->get('not_in_items', []);
        //视频列表
        $items = ShortVideoModule::getNormalList($not_in_items, 5);
        //视频列表渲染
        $view = view('short-video._items', compact('items'))->render();

        $items         = $items->toArray();
        $items['view'] = $view;
        return $items;
    }
}