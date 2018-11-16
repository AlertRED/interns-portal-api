<?php

namespace App\Http\Middleware;

use App\Support\Enums\UserType;
use Closure;

class EmployeeOnly
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
            UserType::getKey(UserType::Employee)
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
