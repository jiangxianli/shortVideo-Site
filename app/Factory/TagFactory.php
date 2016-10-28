<?php
namespace App\Factory;

use App\Model\ShortVideo;
use App\Model\ShortVideoTag;
use App\Model\Tag;

class TagFactory
{

    public static function tagModel()
    {
        return new Tag();
    }


    public static function tagSearch($condition)
    {

        $builder = self::tagModel();

        //　define selected rows
        if ($default_select = array_get($condition, 'default_select', [])) {
            $builder = $builder->select($default_select);
        }

        if ($default_relation = array_get($condition, 'default_relation', [])) {
            $builder = $builder->with($default_relation);
        }

        if ($id = array_get($condition, 'id', [])) {
            $builder = $builder->where('id', $id);
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