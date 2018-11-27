<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 25.09.18
 * Time: 14:45
 */

namespace App\Http\Controllers\V1\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\UpdateUserPermissions;
use App\Http\Transformers\V1\Course\InternshipCourseTransformer;
use App\Models\Internship\InternshipCourse;
use App\Models\Permissions\CourseUserRight;
use App\Repositories\Permissions\CourseUserRightsRepository;
use App\Support\Enums\UserCourseRight;
use App\Support\Enums\UserType;
use App\Support\Permissions\PermissionPool;
use App\User;

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allPermissionsList() {
        $permissions = [];

        foreach (UserCourseRight::getKeys() as $right) {
            $permissions[$right] = __("courses." . $right);
        }

        return response()->json([
            "success" => true,
            "data" => [
                "permissions" => $permissions
            ]
        ]);
    }

    /**
     * @param InternshipCourse $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(InternshipCourse $course)
    {
        return response()->json([
            "success" => true,
            "data" => [
                "course" => InternshipCourseTransformer::transformItem($course)
            ]
        ]);
    }

    /**
     * @param InternshipCourse $course
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserCoursePermissions(InternshipCourse $course, User $user) {
        if ($user->role !== UserType::Employee) {
            abort(422, "Пользоваель должен быть сотрудником");
        }

        return response()->json ([
            "success" => true,
            "data" => [
                "permissions" => PermissionPool::getUserCourseRights($user, $course)
            ]
        ]);
    }

    /**
     * @param UpdateUserPermissions $request
     * @param InternshipCourse $course
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserCoursePermissions(UpdateUserPermissions $request, InternshipCourse $course, User $user) {
        if ($user->role !== UserType::Employee) {
            abort(422, "Пользоваель должен быть сотрудником");
        }

        if (isset($request->permissions)) {
            foreach ($request->permissions as $key => $val) {
                $right = CourseUserRight::firstOrCreate([
                    "course_id" => $course->id,
                    "user_id" => $user->id,
                    "right" => $key,
                ]);
                CourseUserRightsRepository::update($right, [
                    "allowed" => $val
                ]);
            }
        }

        return response()->json([
            "success" => true,
            "data" => [
                "permissions" => PermissionPool::getUserCourseRights($user,$course)
            ]
        ]);
    }
}