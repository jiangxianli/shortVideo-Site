<?php
namespace App\Factory;

use App\Model\ShortVideo;
use App\Model\ShortVideoTag;
use App\Model\Tag;

class ShortVideoFactory
{

    public static function shortVideoModel()
    {
        return new ShortVideo();
    }

    public static function tagModel()
    {
        return new Tag();
    }

    public static function shortVideoTagModel()
    {

        return new ShortVideoTag();
    }


    public static function shortVideoSearch($condition)
    {
        $builder = self::shortVideoModel();

        //　define selected rows
        if ($default_select = array_get($condition, 'default_select', [])) {
            $builder = $builder->select($condition);
        }

        if ($default_relation = array_get($condition, 'default_relation', [])) {
            $builder = $builder->with($default_relation);
        }

        if ($id = array_get($condition, 'id', [])) {
            $builder = $builder->where('id', $id);
        }

        if ($status = array_get($condition, 'status', [])) {
            $builder = $builder->whereIn('status', $status);
        }

        if ($platform_type = array_get($condition, 'platform_type', [])) {
            $builder = $builder->whereIn('platform_type', $platform_type);
        }

        if ($not_in_items = array_get($condition, 'not_in_items', [])) {
            foreach ($not_in_items as $column => $value) {
                $builder = $builder->whereNotIn($column, $value);
            }
        }

        if ($not_in_items = array_get($condition, 'in_items', [])) {
            foreach ($not_in_items as $column => $value) {
                $builder = $builder->whereIn($column, $value);
            }
        }

        return $builder;

    }

}