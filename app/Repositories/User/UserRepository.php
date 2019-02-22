<?php

namespace App\Repositories\User;

use App\Models\Internship\InternshipCourse;
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
        InternHomeworkSync::syncInternsHomeworks($course->users);
        return User::create($data);
    }
}