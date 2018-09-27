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
use App\Models\Homework\InternHomework;
use App\Models\Internship\InternshipCourse;
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
            "course_id" => "required|integer|exists:internship_courses,id",
            "url" => "string|min:4|max:255",
            "deadline" => "required|string",
        ]);

        $deadline = null;

        try {
            $deadline = Carbon::parse($request->deadline);
        } catch (\Exception $e) {
            abort(500, "Неверный формат datetime");
        }

        $homework = Homework::create([
            "name" => $request->name,
            "number" => $request->number,
            "url" => $request->url ? $request->url : "",
            "course_id" => $request->course_id,
            "deadline" => $deadline
        ]);

        $course = InternshipCourse::find($request->course_id);

        $interns = User::where("course", $course->course)->get();

        foreach ($interns as $intern) {
            InternHomework::firstOrCreate([
                "user_id" => $intern->id,
                "homework_id" => $homework->id,
            ]);
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homework" => HomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        $homework = Homework::find($id);

        if (!$homework) {
            abort(404, "Домашняя работа не найдена");
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homework" => HomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $request->validate([
            "name"      => "string|min:4|max:255",
            "number"    => "integer",
            "course_id" => "integer|exists:internship_courses,id",
            "url"       => "string|min:4|max:255",
            "deadline"  => "string",
        ]);

        $homework = Homework::find($id);

        $homework->update([
            "name"      => $request->name ? $request->name : $homework->name,
            "number"    => $request->number ? $request->number : $homework->number,
            "url"       => $request->url ? $request->url : $homework->url,
            "course_id" => $request->course_id ? $request->course_id : $homework->course_id,
            "deadline"  => $request->deadline ? Carbon::parse($request->deadline) : $homework->deadline
        ]);

        return response()->json([
            "success" => true,
            "data"    => [
                "homework" => HomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id) {
        $homework = Homework::find($id);

        if (!$homework) {
            abort(404, "Домашняя работа не найдена");
        }

        $homework->delete();

        return response()->json([
            "success" => true,
        ]);
    }
}