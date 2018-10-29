<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 25.09.18
 * Time: 12:11
 */

namespace App\Http\Controllers\V1\Homework;

use App\Http\Controllers\Controller;
use App\Http\Transformers\V1\Homework\InternHomeworkTransformer;
use App\Models\Homework\InternHomework;
use App\Repositories\Homework\InternHomeworkRepository;
use App\Support\Enums\HomeworkStatus;
use App\Support\InternHomework\Util\InternHomeworkUtils;
use App\Support\Notifications\Notifiers\EmployeeNotifier;
use App\User;
use Illuminate\Http\Request;

class InternHomeworkController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyHomeworks(Request $request)
    {
        $request->validate([
            'active' => 'boolean'
        ]);

        $me = auth("api")->user();

        $myHomeworks = InternHomework::where("user_id", $me->id)->get();

        if (isset($request->active)) {
            $myHomeworks = $request->active == true ?
                InternHomework::filterActive($myHomeworks) :
                InternHomework::filterInActive($myHomeworks);
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homeworks" => InternHomeworkTransformer::transformCollection($myHomeworks)
            ]
        ]);
    }

    /**
     * @param InternHomework $myHomework
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(InternHomework $myHomework)
    {
        if (!$myHomework) {
            abort(404, "Домашняя работа не найдена");
        }

        if (!InternHomeworkUtils::isUserHasHomeworkAccess(auth("api")->user(), $myHomework)) {
            abort(403, "Нет доступа");
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homework" => InternHomeworkTransformer::transformItem($myHomework)
            ]
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserHomeworks($id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, "Пользователь не найден");
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homeworks" => InternHomeworkTransformer::transformCollection(
                    InternHomework::where("user_id", $user->id)->get()
                )
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param InternHomework $myHomework
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, InternHomework $myHomework)
    {
        $request->validate([
            "github_uri" => "string|min:4|max:255",
        ]);

        $me = auth("api")->user();

        if (!InternHomeworkUtils::isUserHasHomeworkAccess($me, $myHomework)) {
            abort(403, "Нет доступа");
        }

        $myHomework = InternHomeworkRepository::update($myHomework, [
            "github_uri" => isset($request->github_uri) ? $request->github_uri : $myHomework->github_uri,
        ]);

        if (isset($request->github_uri) && $myHomework->status == HomeworkStatus::getKey(HomeworkStatus::InProgress)) {
            $myHomework = InternHomeworkUtils::changeStatus(
                null, $myHomework, HomeworkStatus::getKey(HomeworkStatus::OnReview), true
            );
            EmployeeNotifier::notifyEmployeeHomeworkOnReview($myHomework);
        }

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => InternHomeworkTransformer::transformItem($myHomework)
            ]
        ]);
    }

    /**
     * @param $id
     * @param InternHomework $homework
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserHomework($id, InternHomework $homework) {
        $user = User::find($id);

        if (!$user) {
            abort(404, "Пользователь не найден");
        }

        if ($homework->user_id != $user->id) {
            abort(400, "Домашняя работа не принадлежит пользователю");
        }

        if (!InternHomeworkUtils::isUserHasHomeworkAccess(auth("api")->user(), $homework)) {
            abort(403, "Нет доступа");
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homework" => InternHomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param InternHomework $homework
     * @return \Illuminate\Http\JsonResponse
     */
    public function editUserHomework(Request $request, User $user, InternHomework $homework) {
        $request->validate([
            "status" => "string|min:4|max:255",
            "github_uri" => "string|min:4|max:255"
        ]);

        if (isset($request->status)) {
            if (!HomeworkStatus::isStatusExists($request->status)) {
                abort(400, "Неверный статус");
            }
        }

        if ($homework->user_id != $user->id) {
            abort(400, "Домашняя работа не принадлежит пользователю");
        }

        if (isset($request->status)) {
            $homework = InternHomeworkUtils::changeStatus(auth("api")->user(), $homework, $request->status);
        }

        $homework = InternHomeworkRepository::update($homework, [
            "github_uri" => isset($request->github_uri) ? $request->github_uri : $homework->github_uri,
        ]);

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => InternHomeworkTransformer::transformItem($homework)
            ]
        ]);
    }
}