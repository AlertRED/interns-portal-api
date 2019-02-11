<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 11.02.19
 * Time: 16:36
 */

namespace App\Console\Commands\Testing;

use Illuminate\Console\Command;
use Mail;

class MailTesting extends Command
{
    protected $signature = "mail:testing";

    public function handle() {
        $user = new \stdClass();
        $user->login = "myLogin";
        $user->email = "testEmail";
        $user->course = new \stdClass();
        $user->course->course = "course test name";

        $mailData = [
            'fullName' => "test full name",
            'user' => $user
        ];

        Mail::send("emails.employee.user_registered", $mailData, function ($mail) {
            $mail->from('mailer@learn.2-up.ru', '2Up Interns Portal');
            $mail->to("testreceiver@2-up.ru", "Test receiver")->subject("mail title!");
        });
    }
}