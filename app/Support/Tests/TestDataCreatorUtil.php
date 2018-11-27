<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 9:34
 */

namespace App\Support\Tests;

use App\Models\Internship\CourseLead;
use App\Models\Internship\InternshipCourse;
use App\User;
use Hash;

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
     * @var
     */
    private $course;

    /**
     * @var CourseLead
     */
    private $courseLead;

    /**
     * @param bool $getNew
     * @return User
     */
    public function getUser($getNew = false) {
        if (!$this->user) {
            $user = User::create([
                "login" => "testUser_" . str_random(10),
                "email" => "testEmail" . str_random(7) . "@domain.test",
                "first_name" => "testName" . str_random(5),
                "api_token" => str_random(30),
                "password" => Hash::make('1234')
            ]);

            if ($getNew) {
                return $user;
            }

            $this->user = $user->refresh();
        }
        return $this->user;
    }

    /**
     * @return InternshipCourse
     */
    public function getCourse() {
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
    public function getCourseLead() {
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
        if ($this->course) {
            $this->course->delete();
        }
        if ($this->courseLead) {
            $this->courseLead->delete();
        }
    }
}