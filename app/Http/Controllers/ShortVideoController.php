<?php
namespace App\Http\Controllers;

use App\Module\ShortVideoModule;
use Illuminate\Http\Request;

class ShortVideoController extends Controller
{
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

    public function postClickCount(Request $request,$id){

        ShortVideoModule::incrementClickCount($id);

    }
}