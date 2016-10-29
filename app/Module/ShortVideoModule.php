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
    public static function getWatchList($not_in_items, $in_items, $per_page)
    {
        $short_video = ShortVideoFactory::shortVideoSearch([
            'default_relation' => [
                'tags' => function () {

                }
            ],
            'not_in_items'     => [
                'id' => $not_in_items
            ],
            'in_items'         => [
                'id' => $in_items
            ]
        ]);

        return $short_video->paginate($per_page);
    }

    /**
     * 更新视频播放次数
     *
     * @param $id
     * @author  jiangxianli
     * @created_at 2016-10-29 13:46:51
     */
    public static function incrementClickCount($id)
    {
        $item = ShortVideoFactory::shortVideoSearch([
            'id' => $id
        ])->first();
        if ($item) {
            $item->increment('click_count');
        }
    }

    /**
     * 更新视频随机数
     *
     * @author  jiangxianli
     * @created_at 2016-10-29 16:17:46
     */
    public static function updateRandom()
    {
        $short_video_count = ShortVideoFactory::shortVideoSearch([])->count();
        $per_page          = 1000;
        $last_page         = ceil($short_video_count / $per_page);
        for ($i = 1; $i <= $last_page; $i++) {
            $short_videos = ShortVideoFactory::shortVideoSearch([])->skip(($i - 1) * $per_page)->take($per_page)->get();
            foreach ($short_videos as $short_video) {
                $short_video->random = str_random(rand(16, 32));
                $short_video->save();
            }
        }
    }

}