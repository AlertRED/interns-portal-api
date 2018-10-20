<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 27.09.18
 * Time: 10:32
 */

namespace App\Support\InternHomework\Util;

use App\Models\Homework\Homework;
use App\Models\Homework\InternHomework;
use App\Models\Internship\InternshipCourse;
use App\Support\Enums\HomeworkStatus;
use App\Support\Enums\UserType;
use App\User;

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

        if (!in_array($homework->status, HomeworkStatus::getKeys())) {
            $homework->update([
                "status" => HomeworkStatus::getKey(HomeworkStatus::NotStarted)
            ]);
        }

        if (!in_array($me->role, $allowedRoles)) {
            abort(403, "Группа  " . $me->role . " не может изменять статус домашних заданий");
        }

        $homework->update([
            "status" => $newStatus
        ]);

        return $homework;
    }

    /**
     * @param Homework $homework
     * @param InternshipCourse $course
     */
    public static function assignHomeworkToInterns(Homework $homework, InternshipCourse $course) {
        $interns = User::where("role", UserType::getKey(UserType::User))
            ->where("course_id", $course->id)
            ->get();

        foreach ($interns as $intern) {
            $homework = InternHomework::where("user_id", $intern->id)
                ->where("homework_id", $homework->id)
                ->first();
            if (!$homework) {
                InternHomework::create([
                    "user_id" => $intern->id,
                    "homework" => $homework->id,
                    "status" => InternHomework::getDefaultStatus()
                ]);
            }
        }
    }
}