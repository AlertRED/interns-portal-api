<?php
/**
 * Created by Max K
 * Date: 13.09.18
 * Time: 12:21
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class ApiConfigController extends Controller
{
    /**
     * [Api.Version]
     *
     * @return Illuminate\Http\Response
     */
    public function version()
    {
        return response()->json([
            'version' => '1.0',
            'status' => 'working',
        ]);
    }
}