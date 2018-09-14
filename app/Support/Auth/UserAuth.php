<?php
/**
 * Created by Max K
 * Date: 13.09.18
 * Time: 12:07
 */

namespace App\Support\Auth;

use App\User;

class UserAuth
{
    /**
     * @param User $user
     * @return User
     */
    public static function regenUserAPIToken(User $user) {
        $user->update([
            "api_token" => str_random(30)
        ]);
        return $user;
    }
}