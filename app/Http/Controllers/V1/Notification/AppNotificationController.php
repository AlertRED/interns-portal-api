<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 20.10.18
 * Time: 18:31
 */

namespace App\Http\Controllers\V1\Notification;

use App\Http\Controllers\Controller;
use App\Http\Transformers\V1\Notification\AppNotificationTransformer;
use App\Models\Notification\AppNotification;

class AppNotificationController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatest() {
        $pageLimit = 10;
        $me = auth("api")->user();

        $notifications = AppNotification::where("user_id", $me->id)
            ->orderBy("seen", "asc")
            ->orderBy("created_at", "desc")
            ->take($pageLimit)
            ->get();

        return response()->json([
            "success" => true,
            "data" => [
                "notifications" => AppNotificationTransformer::transformCollection($notifications)
            ],
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAllToSeen() {
        $me = auth("api")->user();

        AppNotification::where("user_id", $me->id)
            ->where("seen", false)
            ->update(["seen" => true]);

        return response()->json([
            "success" => true
        ]);
    }
}