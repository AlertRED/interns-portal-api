<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 29.10.18
 * Time: 16:02
 */

namespace App\Support\Notifications\Notifiers;

use App\Jobs\Notifications\ProcessNotificationJob;
use App\Models\Homework\InternHomework;
use App\Support\Notifications\Notification;
use Queue;

class InternNotifier
{
    /**
     * @param InternHomework $homework
     */
    public static function notifyUserHomeworkStatusChanged(InternHomework $homework) {
        $notification = new Notification(
            "У домашней работы №" . $homework->homework->number . " " . $homework->homework->name . " изменился статус на " . $homework->status
            , $homework->user
        );

        $notification->setNotificationTypes(["app", "email"]);

        $notification->setData([
            "mail_view" => "emails.user.homework.status_changed"
        ]);

        $notification->setMailData([
            "homework" => $homework
        ]);

        Queue::push(new ProcessNotificationJob($notification));
    }
}