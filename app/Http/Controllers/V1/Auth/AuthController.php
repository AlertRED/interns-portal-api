<?php

/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 9:51
 */

namespace App\Http\Controllers\V1\Auth;

use App\Models\Auth\RegistrationKey;
use App\Support\Enums\UserType;
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
    public function register(Request $request) {
        $request->validate([
            "login" => "required|string|unique:users,login|min:3|max:255",
            "email" => "required|email|unique:users,email|max:255",
            "first_name" => "required|string|min:3|max:100",
            "last_name" => "required|string|min:3|max:100",
            "password" => "required|string|min:4|max:50",
            "register_key" => "required|string|min:4|max:255"
        ]);

        $registrationKey = RegistrationKey::where("key", $request->register_key)->first();

        if (!$registrationKey) {
            return response()->json([
                "success" => false,
                "message" => "Неверный ключ регистрации"
            ], 403);
        }

        if ($registrationKey->is_used) {
            return response()->json([
                "success" => false,
                "message" => "Ключ уже использован"
            ], 403);
        }

        $user = User::create([
            "login"      => $request->login,
            "email"      => $request->email,
            "first_name" => $request->first_name,
            "api_token"  => str_random(30),
            "password"   => Hash::make('1234')
        ]);

        return response()->json([
            "success" => true,
            "data" => [
                "api_token" => $user->api_token
            ]
        ], 200);
    }
}