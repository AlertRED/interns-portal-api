<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 16.11.18
 * Time: 17:59
 */

namespace Tests\Unit\Model\Internship;

use App\Support\Tests\TestDataCreatorUtil;
use Tests\TestCase;

class CourseLeadTests extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function getUserTest() {
        $util = new TestDataCreatorUtil();

        $user = $util->getUser();
        $course = $util->getCourse();
        $lead = $util->getCourseLead();

        $this->assertTrue($lead->user->id == $user->id);
        $this->assertTrue($lead->course->id == $course->id);

        $util->cleanUp();
    }
}