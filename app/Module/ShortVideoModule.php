<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;

class ShortVideoModule
{
    /**
     * 视频列表
     *
     * @param array $not_in_items 排除ID项
     * @param int $per_page 分页数
     * @return mixed
     * @author  jiangxianli
     * @created_at 2016-10-27 18:40:05
     */
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

    /**
     * 视频详情
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @author  jiangxianli
     * @created_at 2016-10-27 18:40:49
     */
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

    /**
     * 历史观看列表
     *
     * @param $in_items
     * @param $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author  jiangxianli
     * @created_at 2016-10-27 18:55:30
     */
    public static function getWatchList($not_in_items,$in_items, $per_page)
    {
        $short_video = ShortVideoFactory::shortVideoSearch([
            'default_relation' => [
                'tags' => function () {

                }
            ],
            'not_in_items'         => [
                'id' => $not_in_items
            ],
            'in_items'         => [
                'id' => $in_items
            ]
        ]);

        return $short_video->paginate($per_page);
    }

}