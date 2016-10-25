<?php
namespace App\Factory;

use App\Model\ShortVideo;
use App\Model\ShortVideoTag;
use App\Model\Tag;
use App\Model\User;

class UserFactory
{

    public static function userModel()
    {
        return new User();
    }

    public static function createUser(array $array = [])
    {
        $user = self::userModel()->firstOrNew(['duo_shuo_id' => $array['duo_shuo_id']]);
        $user->fill($array);
        $user->save();

        return $user;
    }


}