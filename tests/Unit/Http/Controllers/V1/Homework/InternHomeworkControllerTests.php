<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 29.01.19
 * Time: 12:47
 */

namespace Tests\Unit\Http\Controllers\V1\Homework;

use App\Support\Enums\UserType;
use App\Support\Tests\TestDataCreatorUtil;
use App\Support\User\Util\UserRoles;
use Tests\TestCase;

class InternHomeworkControllerTests extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function GetUserHomeworks_AdminGetHomeworks_Success() {
        $util = new TestDataCreatorUtil();
        $util->getUserHomework();
        $user = $util->getUser();

        $user = UserRoles::updateUserRole($user, UserType::Admin);

        $response = $this->get("/api/v1/user/" . $user->id . "/homeworks?api_token=" . $user->api_token);

        $response->assertStatus(200);
        $response->assertJson(["success" => true]);

        $util->cleanUp();
    }
}