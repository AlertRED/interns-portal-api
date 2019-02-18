<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 26.11.18
 * Time: 11:12
 */

namespace App\Http\Middleware\User;

use App\Support\Enums\UserType;
use Closure;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $me = auth("api")->user();

        $allowedRoles = [
            UserType::getKey(UserType::Admin)
        ];

        if (!in_array($me->role, $allowedRoles)) {
            return response()->json([
                "success" => false,
                "message" => "Нет доступа для групппы " . $me->role
            ], 403);
        }

        return $next($request);
    }
}