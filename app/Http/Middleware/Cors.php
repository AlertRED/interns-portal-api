<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 12.10.18
 * Time: 12:03
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{

    /**
     * Handle an incoming request
     * @param Request $request
     * @param Closure $next
     * @return Closure|mixed
     */
    public function handle(Request $request, Closure $next) {
        $next = $next($request);
        $next->headers->set('Access-Control-Allow-Origin', '*');
        $next->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $next->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization, Accept, Accept-Language');
        $next->headers->set('Access-Control-Max-Age', '600');
        return $next;
    }
}