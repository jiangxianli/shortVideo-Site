<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;

class ShortVideoModule
{


    public static function getNormalList($not_in_items, $per_page)
    {

        $short_video = ShortVideoFactory::shortVideoSearch([
            'default_relation' => [
                'tags' => function () {

                }
            ],
            'not_in_items'     => [
                'id' => $not_in_items
            ]
        ]);

        return $short_video->orderBy('random', 'desc')->paginate($per_page);
    }


    public static function getNormalDetail($id)
    {
        $short_video = ShortVideoFactory::shortVideoSearch([
            'default_relation' => [
                'tags' => function () {

                }
            ],
            'id'               => $id
        ]);

        return $short_video->first();

    }

}