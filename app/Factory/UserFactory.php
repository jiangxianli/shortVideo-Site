<?php
namespace App\Factory;

use App\Model\ShortVideo;
use App\Model\ShortVideoTag;
use App\Model\Tag;
use App\Model\User;

class UserFactory
{
    /**
     * 获取用户模型
     *
     * @return User
     * @author  jiangxianli
     * @created_at 2016-10-29 13:52:52
     */
    public static function userModel()
    {
        return new User();
    }

    /**
     * 创建或更新用户信息
     *
     * @param array $array
     * @return mixed
     * @author  jiangxianli
     * @created_at 2016-10-29 13:53:27
     */
    public static function createUser(array $array = [])
    {
        $user = self::userModel()->firstOrNew(['duo_shuo_id' => $array['duo_shuo_id']]);
        $user->fill($array);
        $user->save();

        return $user;
    }
}