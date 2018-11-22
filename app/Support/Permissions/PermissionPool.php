<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 20.11.18
 * Time: 14:44
 */

namespace App\Support\Permissions;

use App\Models\Internship\InternshipCourse;
use App\Support\Enums\UserCourseRight;
use App\User;

class PermissionPool
{
    /**
     * @param User $me
     * @param InternshipCourse $course
     */
    public static function getMyCoursePermissions(User $me, InternshipCourse $course) {
        $myRights = [];

        // TODO: get course lead
        $isCourseLead = true;
        if ($isCourseLead) {
            foreach (UserCourseRight::getKeys() as $right) {
                dd($right);
            }
        }
    }
}