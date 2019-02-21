<?php

namespace App\Repositories\User;

use App\Models\Internship\InternshipCourse;
use App\Support\InternHomework\Util\InternHomeworkUtils;
use App\Support\Sync\Homework\InternHomeworkSync;
use App\User;

class UserRepository
{
    /**
     * @param array $data
     * @return User
     */
    public static function create(array $data) {
        $course = InternshipCourse::find($data["course_id"]);
        InternHomeworkUtils::syncCourseHomeworks($course);
        InternHomeworkSync::syncInternsHomeworks($course->users);
        return User::create($data);
    }
}