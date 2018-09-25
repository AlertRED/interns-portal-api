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
use Illuminate\Http\Request;

class InternHomeworkController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyHomeworks(Request $request) {
        $request->validate([
            'active' => 'boolean'
        ]);

        $me = auth("api")->user();

        $myHomeworks = InternHomework::where("user_id", $me->id)->get();

        if (isset($request->active)) {
            if ($request->active == true) {
                $myHomeworks = InternHomework::filterActive($myHomeworks);
            } else {
                $myHomeworks = InternHomework::filterInActive($myHomeworks);
            }
        }

        return response()->json([
            "success" => true,
            "data"    => [
                "homeworks" => InternHomeworkTransformer::transformCollection($myHomeworks)
            ]
        ]);
    }
}