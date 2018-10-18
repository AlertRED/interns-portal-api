<?php

namespace App\Http\Controllers\V1\User;

use App\Models\Internship\InternshipCourse;
use Hash;
use App\User;
use Illuminate\Http\Request;
use App\Http\Transformers\V1\User\UserTransformer;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInterns(Request $request)
    {
        $request->validate([
            "course"  => "string|min:1|max:200",
        ]);

        $users = User::where("role", "User")
            ->get();

        if ($request->course) {
            $course = InternshipCourse::where("course", $request->course)->first();
            if (!$course) {
                abort(404, "Курс " . $request->course . " не найден");
            }
            $users = $users->where("course_id", $course->id);
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "users" => UserTransformer::transformCollection($users)
            ]
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(User $user)
    {
        return response()->json([
            "success" => true,
            "data"    => [
                "user" => UserTransformer::transformItem($user)
            ]
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyProfileInfo()
    {
        return response()->json([
            "success" => true,
            "data"    => [
                "user" => UserTransformer::transformItem(
                    User::find(auth("api")->user()->id)
                )
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editMyProfileInfo(Request $request)
    {
        $request->validate([
            "login"      => "string|unique:users,login|min:3|max:255",
            "email"      => "email|unique:users,email|max:255",
            "first_name" => "string|min:3|max:100",
            "last_name"  => "string|min:3|max:100",
            "password"   => "string|min:4|max:50"
        ]);

        $me = auth("api")->user();

        $me->login = $request->login ? $request->login : $me->login;
        $me->email = $request->email ? $request->email : $me->email;
        $me->first_name = $request->first_name ? $request->first_name : $me->first_name;
        $me->last_name = $request->last_name ? $request->last_name : $me->last_name;
        $me->password = $request->password ? Hash::make($request->password) : $me->password;

        $me->save();

        return $this->getUser(auth("api")->user()->id);
    }
}