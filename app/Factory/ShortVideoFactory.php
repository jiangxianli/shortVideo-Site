<?php
namespace App\Factory;

use App\Model\ShortVideo;
use App\Model\ShortVideoTag;
use App\Model\Tag;

class ShortVideoFactory
{

    /**
     * 获取短视频模型
     *
     * @return ShortVideo
     * @author  jiangxianli
     * @created_at 2016-10-29 13:49:08
     */
    public static function shortVideoModel()
    {
        return new ShortVideo();
    }

    /**
     * 获取标签模型
     *
     * @return Tag
     * @author  jiangxianli
     * @created_at 2016-10-29 13:49:24
     */
    public static function tagModel()
    {
        return new Tag();
    }

    /**
     * 获取短视频标签模型
     *
     * @return ShortVideoTag
     * @author  jiangxianli
     * @created_at 2016-10-29 13:49:37
     */
    public static function shortVideoTagModel()
    {
        return new ShortVideoTag();
    }

    /**
     * 短视频查询
     *
     * @param $condition
     * @return ShortVideo|\Illuminate\Database\Eloquent\Builder|static
     * @author  jiangxianli
     * @created_at 2016-10-29 13:49:56
     */
    public static function shortVideoSearch($condition)
    {
        $builder = self::shortVideoModel();

        //默认查询字段
        if ($default_select = array_get($condition, 'default_select', [])) {
            $builder = $builder->select($default_select);
        }
        //默认关联加载
        if ($default_relation = array_get($condition, 'default_relation', [])) {
            $builder = $builder->with($default_relation);
        }
        //主键查询
        if ($id = array_get($condition, 'id', [])) {
            $builder = $builder->where('id', $id);
        }
        //状态查询
        if ($status = array_get($condition, 'status', [])) {
            $builder = $builder->whereIn('status', $status);
        }
        //平台类型查询
        if ($platform_type = array_get($condition, 'platform_type', [])) {
            $builder = $builder->whereIn('platform_type', $platform_type);
        }
        //排除项
        if ($not_in_items = array_get($condition, 'not_in_items', [])) {
            foreach ($not_in_items as $column => $value) {
                $builder = $builder->whereNotIn($column, $value);
            }
        }
        //包括项
        if ($not_in_items = array_get($condition, 'in_items', [])) {
            foreach ($not_in_items as $column => $value) {
                $builder = $builder->whereIn($column, $value);
            }
        }

        return $builder;
    }

}