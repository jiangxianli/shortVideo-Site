<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;

class ShortVideoModule {


    public static function getNormalList($not_in_items,$per_page){

        $short_video = ShortVideoFactory::shortVideoSearch([
            'not_in_items' => [
                'id' => $not_in_items
            ]
        ]);

        return $short_video->paginate($per_page);
    }

}