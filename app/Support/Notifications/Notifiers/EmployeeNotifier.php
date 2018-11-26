<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 26.10.18
 * Time: 19:12
 */

namespace App\Support\Notifications\Notifiers;

use App\Jobs\Notifications\ProcessNotificationJob;
use App\Models\Homework\InternHomework;
use App\Models\Internship\CourseLead;
use App\Models\Internship\InternshipCourse;
use App\Models\Permissions\CourseUserRight;
use App\Support\Enums\UserCourseRight;
use App\Support\Enums\UserType;
use App\Support\Lang\HomeworkStatusesLang;
use App\Support\Notifications\Notification;
use App\User;
use Queue;

class EmployeeNotifier
{
    /**
     * @param InternshipCourse $course
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    private static function getCourseEmployeesToNotify(InternshipCourse $course) {
        $users = collect();
        $usersToNotify = CourseLead::where("course_id", $course->id)->get();
        $usersToNotify = $usersToNotify->merge(CourseUserRight::where("course_id", $course->id)
            ->where("right", UserCourseRight::ViewHomeworks)
            ->get());

        foreach ($usersToNotify as $lead) {
            $users->push($lead->user);
        }

        return $users;
    }

    /**
     * @param User $user
     */
    public static function notifyEmployeeUserRegistered(User $user) {
        foreach (self::getCourseEmployeesToNotify($user->course) as $employee) {
            $notification = new Notification("Стажер " . $user->getFullName() . "(" . $user->course->course
                . ") зарегистрировался на learn.2-up.ru", $employee);

            $notification->setNotificationTypes(["app", "email"]);

            $notification->setData([
                "mail_view" => "emails.employee.user_registered"
            ]);

            $notification->setMailData([
                "user" => $user,
                "fullName" => $user->getFullName()
            ]);

            Queue::push(new ProcessNotificationJob($notification));
        }
    }

    /**
     * @param InternHomework $internHomework
     * @param string $prevStatus
     */
    public static function notifyEmployeeHomeworkStatusChanged(InternHomework $internHomework, $prevStatus = "") {
        foreach (self::getCourseEmployeesToNotify($internHomework->getCourse()) as $employee) {
            $user = $internHomework->user;

            $notification = new Notification(
                "Смена статуса домашней работы № " . $internHomework->homework->number . " - " . $internHomework->homework->name .
                " стажера " . $user->getFullName()
                , $employee
            );

            $notification->setNotificationTypes(["app", "email"]);

            $notification->setData([
                "mail_view" => "emails.employee.homework.status_changed"
            ]);

            $notification->setMailData([
                "homework" => $internHomework,
                "prevStatus" => HomeworkStatusesLang::getTranslated($prevStatus),
                "newStatus" => HomeworkStatusesLang::getTranslated($internHomework->status)
            ]);

            Queue::push(new ProcessNotificationJob($notification));
        }
    }
}