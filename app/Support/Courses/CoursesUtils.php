<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 26.11.18
 * Time: 13:06
 */

namespace App\Support\Courses;

use App\Models\Internship\CourseLead;
use App\Models\Internship\InternshipCourse;

class CoursesUtils
{
    /**
     * @param InternshipCourse $course
     * @return \Illuminate\Support\Collection
     */
    public static function getCourseLeads(InternshipCourse $course) {
        $leads = collect();

        $models = CourseLead::where("course_id", $course->id)
            ->get();

        foreach ($models as $model) {
            if ($model->user) {
                $leads->push($model->user);
            }
        }

        return $leads;
    }
}