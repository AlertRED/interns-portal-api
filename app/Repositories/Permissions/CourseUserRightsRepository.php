<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 26.11.18
 * Time: 12:28
 */

namespace App\Repositories\Permissions;

use App\Models\Permissions\CourseUserRight;

class CourseUserRightsRepository
{
    /**
     * @param CourseUserRight $course
     * @param array $data
     */
    public static function update(CourseUserRight $course, array $data) {
        $course->update($data);
    }
}