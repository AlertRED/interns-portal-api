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
use App\Support\Lang\HomeworkStatusesLang;
use App\Support\Notifications\Notification;
use Queue;

class InternNotifier
{
    /**
     * @param InternHomework $homework
     * @param string $prevStatus
     */
    public static function notifyUserHomeworkStatusChanged(InternHomework $homework, $prevStatus = "") {
        $notification = new Notification(
            "У домашней работы №" . $homework->homework->number . " " . $homework->homework->name . " изменился статус"
            , $homework->user
        );

        $notification->setNotificationTypes(["app", "email"]);

        $notification->setData([
            "mail_view" => "emails.user.homework.status_changed"
        ]);

        $notification->setMailData([
            "homework" => $homework,
            "newStatus" => HomeworkStatusesLang::getTranslated($homework->status),
            "prevStatus" => HomeworkStatusesLang::getTranslated($prevStatus),
        ]);

        Queue::push(new ProcessNotificationJob($notification));
    }
}