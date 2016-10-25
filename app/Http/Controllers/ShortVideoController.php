<?php
/**
 * Created by PhpStorm.
 * User: jiangxianli
 * Date: 16-10-24
 * Time: 上午12:17
 */

namespace App\Http\Controllers;


use App\Module\ShortVideoModule;
use Illuminate\Http\Request;

class ShortVideoController extends Controller
{


    public function getDetail(Request $request, $id)
    {

        $item = ShortVideoModule::getNormalDetail($id);

        return view('short-video.detail', compact('item'));

    }
}