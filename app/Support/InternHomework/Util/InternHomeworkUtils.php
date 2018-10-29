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
use App\Repositories\Homework\InternHomeworkRepository;
use App\Support\Enums\HomeworkStatus;
use App\Support\Enums\UserType;
use App\Support\Notifications\Notifiers\InternNotifier;
use App\Support\User\Util\UserRoles;
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
     * @param bool $force
     * @return InternHomework
     */
    public static function changeStatus($me, InternHomework $homework, string $newStatus, bool $force = false) {
        $allowedRoles = [
            UserType::getKey(UserType::Employee)
        ];

        if (!in_array($homework->status, HomeworkStatus::getKeys())) {
            $homework = InternHomeworkRepository::update($homework, [
                "status" => HomeworkStatus::getKey(HomeworkStatus::NotStarted)
            ]);
        }

        if (!$force && !in_array($me->role, $allowedRoles)) {
            abort(403, "Группа  " . $me->role . " не может изменять статус домашних заданий");
        }

        $homework = InternHomeworkRepository::update($homework, [
            "status" => $newStatus
        ]);

        InternNotifier::notifyUserHomeworkStatusChanged($homework);

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
            $internHomework = InternHomework::where("user_id", $intern->id)
                ->where("homework_id", $homework->id)
                ->first();
            if (!$internHomework && $intern->role == UserType::getKey(UserType::User)) {
                InternHomework::create([
                    "user_id" => $intern->id,
                    "homework_id" => $homework->id,
                    "status" => InternHomework::getDefaultStatus()
                ]);
            }
        }
    }
}