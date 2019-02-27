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
use App\Support\Enums\UserCourseRight;
use App\Support\InternHomework\Util\InternHomeworkUtils;
use App\Support\Lang\HomeworkStatusesLang;
use App\Support\Permissions\PermissionPool;
use App\Support\User\Util\UserUtils;
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
                "homeworks" => InternHomeworkTransformer::transformCollection($myHomeworks, null, true)
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
                "homework" => InternHomeworkTransformer::transformItem($myHomework, null, true)
            ]
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserHomeworks($id)
    {
        $me = User::find(auth("api")->user()->id);
        $user = User::find($id);

        if (!$user) {
            abort(404, "Пользователь не найден");
        }

        if (!PermissionPool::ifUserHasCoursePermission(
            $me, $user->course, UserCourseRight::ViewHomeworks
        )) {
            abort(403, __("homeworks.homework.no_view_access"));
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

        $allowedStatuses = [
            HomeworkStatus::getKey(HomeworkStatus::InProgress)
        ];

        if (!in_array($myHomework->status, $allowedStatuses)) {
            abort(403, "Вы не можете редактировать домашнюю работу с текущим статусом: " . $myHomework->status);
        }

        $myHomework = InternHomeworkRepository::update($myHomework, [
            "github_uri" => isset($request->github_uri) ? $request->github_uri : $myHomework->github_uri,
        ]);

        if (isset($request->github_uri) && $myHomework->status == HomeworkStatus::getKey(HomeworkStatus::InProgress)) {
            $myHomework = InternHomeworkUtils::changeStatus(
                null, $myHomework, HomeworkStatus::getKey(HomeworkStatus::OnReview), true
            );
        }

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => InternHomeworkTransformer::transformItem($myHomework, null, true)
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

        if (!PermissionPool::ifUserHasCoursePermission(
            $user, $user->course, UserCourseRight::ViewHomeworks
        )) {
            abort(403, __("homeworks.homework.no_view_access"));
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

        $me = User::find(auth("api")->user()->id);

        if ($homework->user_id != $user->id) {
            abort(400, "Домашняя работа не принадлежит пользователю");
        }

        if (PermissionPool::ifUserHasCoursePermission(
            $me, $user->course, UserCourseRight::ChangeHomeworkStatuses
        )) {
            if (isset($request->status)) {
                $sourceStatus = HomeworkStatusesLang::getSource($request->status);
                if (!$sourceStatus || !HomeworkStatus::isStatusExists($sourceStatus)) {
                    abort(400, "Неверный статус");
                }
                $homework = InternHomeworkUtils::changeStatus($me, $homework, $sourceStatus);
            }
        }

        if (PermissionPool::ifUserHasCoursePermission(
            $me, $user->course, UserCourseRight::EditHomeworks
        )) {
            $homework = InternHomeworkRepository::update($homework, [
                "github_uri" => isset($request->github_uri) ? $request->github_uri : $homework->github_uri,
            ]);
        }

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => InternHomeworkTransformer::transformItem($homework)
            ]
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvgHomeworkScore(User $user) {
        return response()->json([
            "success" => true,
            "data" => [
                "average_score" => UserUtils::getUserAverageHomeworkScore($user)
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param InternHomework $homework
     * @return \Illuminate\Http\JsonResponse
     */
    public function setHomeworkScore(Request $request, User $user, InternHomework $homework) {
        $me = User::find(auth("api")->user()->id);

        if (!PermissionPool::ifUserHasCoursePermission(
            $me, $user->course, UserCourseRight::ChangeHomeworkStatuses
        )) {
            abort(403, __("homeworks.homework.no_change_status_access"));
        }

        if ($homework->status != HomeworkStatus::getKey(HomeworkStatus::Finished)) {
            abort(403, __("homeworks.homework.invalid_status"));
        }

        $homework->score = floatval($request->score);
        $homework->save();

        return response()->json([
            "success" => true,
            "data" => [
                "homework" => InternHomeworkTransformer::transformItem($homework)
            ]
        ]);
    }
}