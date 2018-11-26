<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 16.11.18
 * Time: 16:24
 */

namespace Tests\Unit\Model;

use App\Support\Tests\TestDataCreatorUtil;
use Tests\TestCase;

class UserTests extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function getCourseLeadTest() {
        $util = new TestDataCreatorUtil();
        $user = $util->getUser();
        $course = $util->getCourse();
        $util->getCourseLead();
        $lead = $user->courseLead;
        $this->assertTrue($lead != null);
        $this->assertTrue($lead->user_id == $user->id);
        $this->assertTrue($lead->course_id == $course->id);
        $util->cleanUp();
    }
}