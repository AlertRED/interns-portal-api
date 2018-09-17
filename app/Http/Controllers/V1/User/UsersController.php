<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Transformers\V1\User\UserTransformer;
use App\User;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Пользователь не найден"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => [
                "user" => UserTransformer::transformItem($user)
            ]
        ], 200);
    }
}