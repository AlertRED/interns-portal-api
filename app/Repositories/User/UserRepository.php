<?php

namespace App\Repositories\User;

use App\Models\Internship\InternshipCourse;
use App\Support\InternHomework\Util\InternHomeworkUtils;
use App\User;

class UserRepository
{
    /**
     * @param array $data
     * @return User
     */
    public static function create(array $data) {
        InternHomeworkUtils::syncCourseHomeworks(InternshipCourse::find($data["course_id"]));
        return User::create($data);
    }
}