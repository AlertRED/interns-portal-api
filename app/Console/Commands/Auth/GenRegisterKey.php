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
    protected $signature = 'auth:gen_register_keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация ключей для регистрации вручную';

    public function handle()
    {
        $this->info("Выберите роль:");
        $allowedRoles = [
            UserType::getKey(UserType::User),
            UserType::getKey(UserType::Employee),
            UserType::getKey(UserType::Admin)
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
        $selectedCourseId = intval($this->ask("Введите id потока:"));

        $selectedCourse = InternshipCourse::find($selectedCourseId);
        if (!$selectedCourse) {
            dd("Выбранный курс не существует");
        }
        $amountLeft = intval($this->ask("Укажите кол-во ключей"));

        $keys = collect();

        while ($amountLeft > 0) {
            $amountLeft--;
            $keys->push(RegistrationKey::create([
                "key" => str_random(25),
                "role" => $allowedRoles[$selectedRoleKey],
                "course_id" => $selectedCourse->id
            ]));
        }

        foreach ($keys as $index => $registerKey) {
            $this->info("Ключ №" . $registerKey->id . "\n");
            $this->info($registerKey->key . "\n");
        }
    }
}