<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 27.09.18
 * Time: 10:32
 */

namespace App\Support\InternHomework\Util;


use App\Models\Homework\InternHomework;
use App\Support\Enums\HomeworkStatus;
use App\Support\Enums\UserType;

class InternHomeworkUtils
{
    /**
     * @param $me
     * @param InternHomework $homework
     * @return bool
     */
    public static function isUserHasHomeworkAccess($me, InternHomework $homework) {
        return $me->id == $homework->user_id || $me->role == UserType::getKey(UserType::Employee);
    }

    /**
     * @param $me
     * @param InternHomework $homework
     * @param string $newStatus
     * @return InternHomework
     */
    public static function changeStatus($me, InternHomework $homework, string $newStatus) {
        $allowedRoles = [
            UserType::getKey(UserType::Employee)
        ];

        $allowedStatuses = [
            HomeworkStatus::getKey(HomeworkStatus::InProgress),
            HomeworkStatus::getKey(HomeworkStatus::OnReview)
        ];

        if (!in_array($newStatus, $allowedStatuses) && !in_array($me->role, $allowedRoles)) {
            abort(403, "Вы не можете изменять текущий статус");
        }

        $homework->update([
            "status" => $newStatus
        ]);

        return $homework;
    }
}