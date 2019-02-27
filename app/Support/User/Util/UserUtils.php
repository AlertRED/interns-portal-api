<?php
/**
 * Created by Max Kovalenko.
 * User: mxss
 * Date: 27.02.19
 * Time: 16:59
 */

namespace App\Support\User\Util;

use App\User;

class UserUtils
{
    public static function getUserAverageHomeworkScore(User $user) : float {
        $homeworks = $user->homeworks;
        return $homeworks->count() > 0 ? $homeworks->sum("score") / $homeworks->count() : 0;
    }
}