<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 12:11
 */

namespace App\Support\User\Util;

use App\User;
use App\Support\Enums\UserType;

class UserRoles
{

    /**
     * @param User $user
     * @param string $newRole
     * @return User
     */
    public static function updateUserRole(User $user, string $newRole)
    {
        if (in_array($newRole, UserType::getKeys())) {
            $user->update([
                "role" => $newRole
            ]);
        }
        return $user;
    }
}