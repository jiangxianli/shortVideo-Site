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

class ApiController extends Controller{


    public function getNormalList(Request $request){

        $not_in_items = $request->get('not_in_items',[]);

        $items = ShortVideoModule::getNormalList($not_in_items,5);

        return view('short-video._items',compact('items'))->render();

    }
}