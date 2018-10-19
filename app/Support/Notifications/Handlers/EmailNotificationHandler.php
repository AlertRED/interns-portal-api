<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 19.10.18
 * Time: 15:25
 */

namespace App\Support\Notifications\Handlers;

use Mail;
use App\Support\Notifications\Notification;

class EmailNotificationHandler
{
    /**
     * @param Notification $notification
     */
    public static function process(Notification $notification) {
        $receiver = $notification->getReceiver();

        Mail::send($notification->getData()["mail_view"], $notification->getMailData(), function ($mail) use ($receiver, $notification) {
            $mail->from('mailer@learn.2-up.ru', '2Up Interns Portal');
            $receiverFullName = $receiver->first_name . " " . $receiver->last_name;
            $mail->to($receiver->email, $receiverFullName)->subject($notification->getTitle());
        });
    }
}