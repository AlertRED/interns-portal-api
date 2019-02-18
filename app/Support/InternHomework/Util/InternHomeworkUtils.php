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
use App\Support\Notifications\Notifiers\EmployeeNotifier;
use App\Support\Notifications\Notifiers\InternNotifier;
use App\User;

class InternHomeworkUtils
{
    /**
     * @param $me
     * @param InternHomework $homework
     * @return bool
     */
    public static function isUserHasHomeworkAccess($me, InternHomework $homework) : bool {
        $result = $me->id == $homework->user_id;
        $result = !$result ? $me->role == UserType::getKey(UserType::Admin) : $result;
        // TODO: get from permission pool
        //$result = !$result ? CourseLead::where("user_id"$me->id) : $result;
        return $result;
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

        $prevStatus = $homework->status;

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

        if ($prevStatus != $homework->status) {
            EmployeeNotifier::notifyEmployeeHomeworkStatusChanged($homework, $prevStatus);
            InternNotifier::notifyUserHomeworkStatusChanged($homework, $prevStatus);
        }

        return $homework;
    }

    /**
     * @param InternshipCourse $course
     */
    public static function syncCourseHomeworks(InternshipCourse $course) {
        foreach (Homework::where("course_id", $course->id)->get() as $homework) {
            self::assignHomeworkToInterns($homework);
        }
    }

    /**
     * @param Homework $homework
     */
    public static function assignHomeworkToInterns(Homework $homework) {
        $interns = User::where("role", UserType::getKey(UserType::User))
            ->where("course_id", $homework->course_id)
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