<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 24.09.18
 * Time: 11:11
 */

namespace App\Http\Controllers\V1\Homework;

use App\Http\Controllers\Controller;
use App\Http\Transformers\V1\Homework\HomeworkTransformer;
use App\Models\Homework\Homework;
use App\Models\Internship\InternshipCourse;
use App\Repositories\Homework\HomeworkRepository;
use App\Support\Enums\HomeworkStatus;
use App\Support\Enums\UserCourseRight;
use App\Support\InternHomework\Util\InternHomeworkUtils;
use App\Support\Lang\HomeworkStatusesLang;
use App\Support\Permissions\PermissionPool;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $request->validate([
            "course" => "string|min:1|max:200",
        ]);

        $homeworks = Homework::all();

        if ($request->course) {
            $course = InternshipCourse::where("course", $request->course)->first();
            if ($course) {
                $homeworks = $homeworks->where("course_id", $course->id);
            } else {
                $homeworks = collect();
            }
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homeworks" => HomeworkTransformer::transformCollection($homeworks)
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function new(Request $request) {
        $request->validate([
            "name" => "required|string|min:4|max:255",
            "number" => "required|integer|min:1|max:32000",
            "course" => "required|string|exists:internship_courses,course",
            "url" => "string|min:4|max:255",
            "deadline" => "required|string",
            "start_date" => "required|string"
        ]);

        $dates = [
            "deadline" => null,
            "start_date" => null
        ];

        try {
            $dates["deadline"] = Carbon::parse($request->deadline);
        } catch (\Exception $e) {
            abort(422, "Неверный формат дедлайна (datetime)");
        }

        try {
            $dates["start_date"] = Carbon::parse($request->start_date);
        } catch (\Exception $e) {
            abort(422, "Неверный формат даты старта (datetime)");
        }

        $course = InternshipCourse::where("course", $request->course)->first();

        if (!$course) {
            abort(404, "Поток не найден");
        }

        $me = User::find(auth()->user()->id);

        if (!PermissionPool::ifUserHasCoursePermission($me, $course, UserCourseRight::EditHomeworks)) {
            abort(403, __("homeworks.homework.no_edit_access"));
        }

        $homework = HomeworkRepository::create([
            "name" => $request->name,
            "number" => $request->number,
            "url" => $request->url ? $request->url : "",
            "course_id" => $course->id,
            "deadline" => $dates["deadline"],
            "start_date" => $dates["start_date"]
        ]);

        return response()->json([
            "success" => true,
            "data"    => [
                "homework" => HomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param Homework $homework
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Homework $homework)
    {
        if (!PermissionPool::ifUserHasCoursePermission(
            User::find(auth()->user()->id), $homework->course, UserCourseRight::ViewHomeworks
        )) {
            abort(403, __("homeworks.homework.no_view_access"));
        }

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => HomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param Homework $homework
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Homework $homework, Request $request) {
        $request->validate([
            "name" => "string|min:4|max:255",
            "number" => "integer",
            "url" => "string|min:4|max:255",
            "deadline" => "string",
            "start_date" => "string",
        ]);

        $dates = [];

        $me = User::find(auth()->user()->id);

        try {
            $dates["deadline"] = Carbon::parse($request->deadline);
        } catch (\Exception $e) {
            abort(422, "Неверный формат дедлайна (deadline)");
        }

        try {
            $dates["start_date"] = Carbon::parse($request->start_date);
        } catch (\Exception $e) {
            abort(422, "Неверный формат даты старта (start_date)");
        }

        if (!PermissionPool::ifUserHasCoursePermission(
            $me, $homework->course, UserCourseRight::EditHomeworks
        )) {
            abort(403, __("homeworks.homework.no_edit_access"));
        }

        $homework->update([
            "name" => $request->name ? $request->name : $homework->name,
            "number" => $request->number ? $request->number : $homework->number,
            "url" => $request->url ? $request->url : $homework->url,
            "start_date" => $request->start_date ? $dates["start_date"] : $homework->start_date,
            "deadline" => $request->deadline ? $dates["deadline"] : $homework->deadline
        ]);

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => HomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param Homework $homework
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Homework $homework) {
        if (!PermissionPool::ifUserHasCoursePermission(
            User::find(auth()->user()->id), $homework->course, UserCourseRight::EditHomeworks
        )) {
            abort(403, __("homeworks.homework.no_edit_access"));
        }

        $homework->delete();

        return response()->json([
            "success" => true,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCourse(Request $request, $id) {
        $request->validate([
            "course_id" => "required|integer|min:1"
        ]);

        $homework = Homework::find($id);

        if (!$homework) {
            abort(404, "Домашняя работа не найдена");
        }

        if (!PermissionPool::ifUserHasCoursePermission(
            User::find(auth()->user()->id), $homework->course, UserCourseRight::EditHomeworks
        )) {
            abort(403, __("homeworks.homework.no_edit_access"));
        }

        $course = InternshipCourse::find($request->course_id);

        if (!$course) {
            abort(404, "Поток не найден");
        }

        InternHomeworkUtils::assignHomeworkToInterns($homework);

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => HomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHomeworkStatuses() {
        $statuses = [];

        foreach (HomeworkStatus::getKeys() as $key) {
            $statuses[] = HomeworkStatusesLang::getTranslated($key);
        }

        return response()->json([
            "success" => true,
            "data" => [
                "statuses" => $statuses
            ]
        ]);
    }
}