<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 11:36
 */

namespace App\Console\Commands\Auth;

use App\Models\Auth\RegistrationKey;
use App\Models\Internship\InternshipCourse;
use App\Support\Enums\UserType;
use Illuminate\Console\Command;

/**
 * Class GenRegisterKey
 * @package App\Console\Commands\Auth
 */
class GenRegisterKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:gen_register_key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация ключа для регистрации вручную';

    public function handle()
    {
        $this->info("Выберите роль:");
        $allowedRoles = [
            UserType::getKey(UserType::User),
            UserType::getKey(UserType::Employee)
        ];

        foreach ($allowedRoles as $key => $allowedRole) {
            $this->info($key . " : " . $allowedRole);
        }
        $selectedRoleKey = intval($this->ask("Введите число:"));
        if (!isset($allowedRoles[$selectedRoleKey])) {
            dd("Неверный role key");
        }

        $this->info("Выберите поток");
        foreach (InternshipCourse::all() as $course) {
            $this->info($course->id . " : " . $course->course);
        }
        $selectedCourseId = intval($this->ask("Введите id:"));

        $selectedCourse = InternshipCourse::find($selectedCourseId);
        if (!$selectedCourse) {
            dd("Выбранный курс не существует");
        }

        $registerKey = RegistrationKey::create([
            "key" => str_random(20),
            "role" => $allowedRoles[$selectedRoleKey],
            "course_id" => $selectedCourse->id
        ]);

        $registerLink = url("/register?") . http_build_query([
            "register_key" => $registerKey->key
                ]);
        $this->info("Register Link:\n" . $registerLink);
        $this->info("Register Key:\n" . $registerKey->key);
    }
}