<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 26.10.18
 * Time: 19:12
 */

namespace App\Support\Notifications\Notifiers;


use App\Jobs\Notifications\ProcessNotificationJob;
use App\Support\Notifications\Notification;
use App\User;
use Queue;

class EmployeeNotifier
{
    /**
     * @param User $user
     */
    public static function NotifyEmployeeUserRegistered(User $user) {
        $employees = User::where("role", "Employee")->get();

        foreach ($employees as $employee) {
            $fullName = $user->first_name . " " . $user->last_name;

            $notification = new Notification("Стажер " . $fullName. " зарегистрировался на learn.2-up.ru", $employee);

            $notification->setNotificationTypes(["app", "email"]);

            $notification->setData([
                "mail_view" => "emails.employee.user_registered"
            ]);

            $notification->setMailData([
                "user" => $user,
                "fullName" => $fullName
            ]);

            Queue::push(new ProcessNotificationJob($notification));
        }
    }
}