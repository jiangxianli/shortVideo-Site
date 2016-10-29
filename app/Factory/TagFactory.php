<?php
namespace App\Factory;

use App\Model\ShortVideo;
use App\Model\ShortVideoTag;
use App\Model\Tag;

class TagFactory
{

    /**
     * 获取标签模型
     *
     * @return Tag
     * @author  jiangxianli
     * @created_at 2016-10-29 13:51:13
     */
    public static function tagModel()
    {
        return new Tag();
    }

    /**
     * 标签查询
     *
     * @param $condition
     * @return Tag|\Illuminate\Database\Eloquent\Builder|static
     * @author  jiangxianli
     * @created_at 2016-10-29 13:51:25
     */
    public static function tagSearch($condition)
    {
        $builder = self::tagModel();

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