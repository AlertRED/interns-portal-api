<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 10.10.18
 * Time: 12:51
 */

namespace App\Repositories\Homework;


use App\Models\Homework\Homework;
use App\Models\Internship\InternshipCourse;
use App\Support\InternHomework\Util\InternHomeworkUtils;

class HomeworkRepository
{
    /**
     * @param array $data
     * @return Homework|\Illuminate\Database\Eloquent\Model
     */
    public static function create(array $data) {
        $homework = Homework::create($data);

        InternHomeworkUtils::assignHomeworkToInterns(
            $homework, InternshipCourse::find($homework->course_id)
        );

        return $homework;
    }
}