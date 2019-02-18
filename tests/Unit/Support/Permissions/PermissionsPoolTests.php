<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 20.11.18
 * Time: 15:05
 */

namespace Tests\Unit\Support\Permissions;

use App\Models\Permissions\CourseUserRight;
use App\Support\Enums\UserCourseRight;
use App\Support\Permissions\PermissionPool;
use App\Support\Tests\TestDataCreatorUtil;
use Tests\TestCase;

class PermissionsPoolTests extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function GetMyCoursePermissions_DataCorrect_Success() {
        $util = new TestDataCreatorUtil();
        $user = $util->getUser();
        $course = $util->getCourse();

        $right = CourseUserRight::firstOrCreate([
            "user_id" => $user->id,
            "course_id" => $course->id,
            "right" => UserCourseRight::EditHomeworks,
            "allowed" => true
        ]);

        $myRights = PermissionPool::getUserCourseRights($user, $course);

        $this->assertTrue($myRights[UserCourseRight::EditHomeworks] == true);
        $this->assertTrue($myRights[UserCourseRight::ViewHomeworks] == false);
        $this->assertTrue($myRights[UserCourseRight::ChangeHomeworkStatuses] == false);

        $right->delete();
        $util->cleanUp();
    }
}