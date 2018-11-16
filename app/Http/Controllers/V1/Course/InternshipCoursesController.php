<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 25.09.18
 * Time: 14:45
 */

namespace App\Http\Controllers\V1\Course;

use App\Http\Controllers\Controller;
use App\Http\Transformers\V1\Course\InternshipCourseTransformer;
use App\Models\Internship\InternshipCourse;

class InternshipCoursesController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return response()->json([
            "success" => true,
            "data" => [
                "courses" => InternshipCourseTransformer::transformCollection(
                    InternshipCourse::all()
                )
            ]
        ]);
    }
}