<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 20.11.18
 * Time: 15:05
 */

namespace Tests\Unit\Support\Permissions;

use App\Support\Tests\TestDataCreatorUtil;
use Tests\TestCase;

class PermissionsPoolTests extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function Test_getMyCoursePermissions() {
        $util = new TestDataCreatorUtil();

        $util->cleanUp();
    }
}