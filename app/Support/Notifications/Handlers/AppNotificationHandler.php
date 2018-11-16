<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 18.10.18
 * Time: 12:24
 */

namespace App\Support\Notifications\Handlers;


use App\Models\Notification\AppNotification;
use App\Support\Notifications\Notification;

class AppNotificationHandler
{
    /**
     * @param Notification $notification
     */
    public static function process(Notification $notification) {
        AppNotification::create([
            "user_id" => $notification->getReceiver()->id,
            "title" => $notification->getTitle(),
            "text" => $notification->getTitle(),
            "uri" => "/"
        ]);
    }
}