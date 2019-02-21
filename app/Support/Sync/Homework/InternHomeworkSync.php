<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 21.02.19
 * Time: 15:28
 */

namespace App\Support\Sync\Homework;

use App\Repositories\Homework\InternHomeworkRepository;
use App\Support\Enums\HomeworkStatus;
use App\Support\Enums\UserType;
use App\User;
use Illuminate\Support\Collection;

class InternHomeworkSync
{
    public static function syncAllInternHomeworks() {
        self::syncInternsHomeworks(User::all());
    }

    /**
     * @param Collection $users
     */
    public static function syncInternsHomeworks(Collection $users) {
        foreach ($users as $i => $user) {
            $users[$i] = self::syncInternHomeworks($user);
        }
    }

    /**
     * @param User $user
     * @return User
     */
    public static function syncInternHomeworks(User $user) {
        if ($user->role != UserType::User || !$user->course) {
            return $user;
        }

        foreach ($user->course->homeworks as $homework) {
            $internHomework = InternHomeworkRepository::firstOrCreate([
                "user_id" => $user->id,
                "homework_id" => $homework->id,
            ]);
            if (!$internHomework->status || !HomeworkStatus::hasKey($internHomework->status)) {
                error_log("У домашней работы с id: " . $internHomework->id . " был неправильный статус");
                $internHomework->status = HomeworkStatus::NotStarted;
                $internHomework->save();
            }
        }

        return $user;
    }
}