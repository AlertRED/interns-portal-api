<?php

/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 9:51
 */

namespace App\Http\Controllers\V1\Auth;

use App\Models\Auth\RegistrationKey;
use App\Repositories\Auth\RegistrationKeyRepository;
use App\Repositories\User\UserRepository;
use App\User;
use Hash;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\V1\Auth
 */
class AuthController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            "login"    => "required|string|min:3|max:255",
            "password" => "required|string|min:4|max:50",
        ]);

        $user = User::where("login", $request->login)->first();

        if (!$user) {
            abort(404, "Пользователь не существует");
        }

        if (!Hash::check($request->password, $user->password)) {
            abort(401, "Неверный логин / пароль");
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "api_token" => $user->api_token
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            "login"        => "required|string|unique:users,login|min:3|max:255",
            "email"        => "required|email|unique:users,email|max:255",
            "first_name"   => "required|string|min:3|max:100",
            "last_name"    => "required|string|min:3|max:100",
            "password"     => "required|string|min:4|max:50",
            "register_key" => "required|string|min:4|max:50"
        ]);

        $registrationKey = RegistrationKey::where("key", $request->register_key)->first();

        if (!$registrationKey) {
            abort(403, "Неверный ключ регистрации");
        }

        if ($registrationKey->is_used) {
            abort(403, "Ключ уже использован");
        }

        $user = UserRepository::create([
            "login"      => $request->login,
            "email"      => $request->email,
            "first_name" => $request->first_name,
            "last_name"  => $request->last_name,
            "course_id"     => $registrationKey->course_id,
            "role"       => $registrationKey->role,
            "api_token"  => str_random(30),
            "password"   => Hash::make($request->password)
        ]);

        RegistrationKeyRepository::update($registrationKey, [
            "is_used" => true,
            "user_id" => $user->id
        ]);

        return response()->json([
            "success" => true,
            "data"    => [
                "api_token" => $user->api_token
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkApiToken(Request $request)
    {
        $request->validate([
            "api_token" => "required|string|min:4|max:50"
        ]);

        $result = User::where("api_token", $request->api_token)->first() !== null;

        return response()->json([
            "success" => $result,
        ], $result ? 200 : 401);
    }
}
