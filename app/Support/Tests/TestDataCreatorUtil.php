<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 9:34
 */

namespace App\Support\Tests;

use App\Models\Homework\Homework;
use App\Models\Homework\InternHomework;
use App\Models\Internship\CourseLead;
use App\Models\Internship\InternshipCourse;
use App\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Collection;

/**
 * @method getDummyUser()
 */
class TestDataCreatorUtil
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Collection
     */
    private $users;

    /**
     * @var Homework
     */
    private $homework;

    /**
     * @var InternHomework
     */
    private $userHomework;

    /**
     * @var
     */
    private $course;

    /**
     * @var CourseLead
     */
    private $courseLead;

    /**
     * TestDataCreatorUtil constructor.
     */
    public function __construct()
    {
        $this->users = collect();
    }

    /**
     * @return User
     */
    public function getUser() : User {
        if (!$this->user) {
            $user = $this->createUser();

            $this->user = $user->refresh();
        }
        return $this->user;
    }

    /**
     * @return User
     */
    public function getNewUser() : User {
        $user = $this->createUser();
        $this->users->push($user);
        return $user;
    }

    /**
     * @return User
     */
    private function createUser() : User
    {
        return User::create([
            "login" => "testUser_" . str_random(10),
            "email" => "testEmail" . str_random(7) . "@domain.test",
            "course_id" => $this->getCourse()->id,
            "first_name" => "testName" . str_random(5),
            "api_token" => str_random(30),
            "password" => Hash::make('1234')
        ]);
    }

    /**
     * @return Homework
     */
    public function getHomework() : Homework {
        if (!$this->homework) {
            $this->homework = Homework::firstOrCreate([
                'name' => "homework-" . str_random(5),
                'number' => rand(1,999),
                'course_id' => $this->getCourse()->id,
                'start_date' => Carbon::now(),
                'deadline' => Carbon::now()->addDay()
            ]);
        }
        return $this->homework;
    }

    public function getUserHomework() : InternHomework {
        if (!$this->userHomework) {
            $user = $this->getUser();
            $homework = $this->getHomework();

            $this->userHomework = InternHomework::firstOrCreate([
                'user_id' => $user->id,
                'homework_id' => $homework->id,
            ]);
        }
        return $this->userHomework;
    }

    /**
     * @return InternshipCourse
     */
    public function getCourse() : InternshipCourse {
        if (!$this->course) {
            $this->course = InternshipCourse::firstOrCreate([
                "course" => "course" . rand(1,9999)
            ]);
        }
        return $this->course;
    }

    /**
     * @return CourseLead
     */
    public function getCourseLead() : CourseLead {
        return CourseLead::firstOrCreate([
            "user_id" => $this->getUser()->id,
            "course_id" => $this->getCourse()->id
        ]);
    }

    /**
     * @throws \Exception
     */
    public function cleanUp() {
        if ($this->user) {
            $this->user->delete();
        }
        foreach ($this->users as $user) {
            $user->delete();
        }
        if ($this->homework) {
            $this->homework->delete();
        }
        if ($this->userHomework) {
            $this->userHomework->delete();
        }
        if ($this->course) {
            $this->course->delete();
        }
        if ($this->courseLead) {
            $this->courseLead->delete();
        }
    }
}