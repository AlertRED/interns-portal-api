<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 20.11.18
 * Time: 14:44
 */

namespace App\Support\Permissions;

use App\Models\Internship\CourseLead;
use App\Models\Internship\InternshipCourse;
use App\Models\Permissions\CourseUserRight;
use App\Support\Enums\UserCourseRight;
use App\Support\Enums\UserType;
use App\User;

class PermissionPool
{
    /**
     * @param User $user
     * @param InternshipCourse $course
     * @return array
     */
    public static function getUserCourseRights(User $user, InternshipCourse $course) {
        $myRights = [];

        foreach (UserCourseRight::getKeys() as $right) {
            $myRights[$right] = false;
        }

        $isCourseLead = CourseLead::where("course_id", $course->id)
            ->where("user_id", $user)
            ->first();

        foreach (UserCourseRight::getKeys() as $right) {
            $userRight = CourseUserRight::where("course_id", $course->id)
                ->where("user_id", $user->id)
                ->where("right", $right)
                ->first();
            $myRights[$right] = $userRight ? boolval($userRight->allowed) : false;
        }

        $allAllowed = $user->role == UserType::Admin || $isCourseLead;

        if ($allAllowed) {
            foreach ($myRights as $key => $right) {
                $myRights[$key] = true;
            }
        }

        return $myRights;
    }

    /**
     * @param User $me
     * @param InternshipCourse $course
     * @param string $right
     * @return bool
     */
    public static function ifUserHasCoursePermission(User $me, InternshipCourse $course, string $right) {
        if (!in_array($right, UserCourseRight::getKeys())) {
            return false;
        }
        return isset(self::getUserCourseRights($me, $course)[$right]) ?
            self::getUserCourseRights($me, $course)[$right] : false;
    }

    /**
     * @param InternshipCourse $course
     * @param User $user
     * @param string $right
     * @param bool $allowed
     */
    public static function updateUserCourseRight(InternshipCourse $course, User $user, string $right, bool $allowed) {
        $right = CourseUserRight::firstOrCreate([
            "course_id" => $course->id,
            "user_id" => $user->id,
            "right" => $right
        ]);
        $right->update([
            "allowed" => $allowed
        ]);
    }
}