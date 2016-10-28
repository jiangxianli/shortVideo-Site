<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;
use App\Factory\TagFactory;

class TagModule
{

   public static function getTagList($not_in_items = [])
   {
       $tags = TagFactory::tagSearch([
           'default_select' => [
               'id','name'
           ],
           'not_in_items' => [
               'id' => $not_in_items
           ]
       ]);

       return $tags->paginate(100);
   }

    public static function getTagDetail($tag_id)
    {
        $tags = TagFactory::tagSearch([
            'default_select' => [
                'id','name'
            ],
            'id' => $tag_id
        ]);

        return $tags->first();
    }


    public static function getTagVideoList($not_in_items = [],$tag_id)
    {
        $items = ShortVideoFactory::shortVideoSearch([
            'not_in_items' => [
                'id' => $not_in_items
            ]
        ])->whereHas('tags',function($query) use ($tag_id){
            $query->where('tag.id',$tag_id);
        })->orderBy(\DB::raw('rand()'));

        return $items->paginate(100);
    }
}