<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;
use App\Factory\TagFactory;

class TagModule
{

    /**
     * 标签列表
     *
     * @param array $not_in_items
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author  jiangxianli
     * @created_at 2016-10-29 13:47:18
     */
    public static function getTagList($not_in_items = [])
    {
        $tags = TagFactory::tagSearch([
            'default_select' => [
                'id', 'name'
            ],
            'not_in_items'   => [
                'id' => $not_in_items
            ],
            //            'default_relation' => [
            //                'shortVideoTag' => function ($query) {
            ////                    $query->select('id');
            //                }
            //            ]
        ]);

        $tags = $tags->paginate(50);

        $short_video_tag  = TagFactory::shortVideoTagSearch([
            'default_select' => [
                'id', 'tag_id', \DB::raw("count(distinct short_video_id) as _count")
            ],
            'in_items'       => [
                'tag_id' => $tags->pluck('id')
            ],
        ]);
        $short_video_tags = $short_video_tag->groupBy('tag_id')->pluck('_count', 'tag_id')->all();
        foreach ($tags as &$tag) {
            if (isset($short_video_tags[$tag->id])) {
                $tag->_count = $short_video_tags[$tag->id];
            } else {
                $tag->_count = 0;
            }
        }

        return $tags;

    }

    /**
     * 标签详情
     *
     * @param $tag_id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @author  jiangxianli
     * @created_at 2016-10-29 13:47:41
     */
    public static function getTagDetail($tag_id)
    {
        $tags = TagFactory::tagSearch([
            'default_select' => [
                'id', 'name'
            ],
            'id'             => $tag_id
        ]);

        return $tags->first();
    }

    /**
     * 标签相关视频
     *
     * @param array $not_in_items
     * @param $tag_id
     * @return mixed
     * @author  jiangxianli
     * @created_at 2016-10-29 13:47:53
     */
    public static function getTagVideoList($not_in_items = [], $tag_id)
    {
        $items = ShortVideoFactory::shortVideoSearch([
            'not_in_items' => [
                'id' => $not_in_items
            ]
        ])->whereHas('tags', function ($query) use ($tag_id) {
            $query->where('tag.id', $tag_id);
        })->orderBy('up', 'desc');

        return $items->paginate(5);
    }
}