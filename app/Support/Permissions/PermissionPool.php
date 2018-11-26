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
        if ($isCourseLead) {
            foreach ($myRights as $right) {
                $myRights[$right] = true;
            }
        }

        foreach (UserCourseRight::getKeys() as $right) {
            $userRight = CourseUserRight::where("course_id", $course->id)
                ->where("user_id", $user->id)
                ->where("right", $right)
                ->first();
            $myRights[$right] = $userRight ? boolval($userRight->allowed) : false;
        }

        return $myRights;
    }

    /**
     * @param User $me
     * @param InternshipCourse $course
     * @param string $right
     * @return bool
     */
    public static function ifUserHaveCoursePermission(User $me, InternshipCourse $course, string $right) {
        if (!in_array($right, UserCourseRight::getKeys())) {
            return false;
        }
        return self::getUserCourseRights($me, $course)[$right];
    }
}