<?php
/**
 * Created by Max K
 * Date: 17.09.18
 * Time: 9:25
 */

namespace Tests\Unit\Http\Controllers\V1\User;

use App\Support\Enums\UserType;
use App\Support\Tests\TestDataCreatorUtil;
use App\Support\User\Util\UserRoles;
use Tests\TestCase;

class AuthControllerTests extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function testGetUser()
    {
        $dataUtil = new TestDataCreatorUtil();
        $user = $dataUtil->getUser();

        $user = UserRoles::updateUserRole($user, UserType::getKey(UserType::Employee));

        $response = $this->get("/api/v1/user/" . $user->id . "?api_token=" . $user->api_token);

        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
        $this->assertContains($user->login, $response->content());

        $dataUtil->cleanUp();
    }

    /**
     * @test
     * @throws \Exception
     */
    public function testCheckApiToken() {
        $dataUtil = new TestDataCreatorUtil();
        $user = $dataUtil->getUser();

        $response = $this->get("/api/v1/check_api_token?api_token=" . $user->api_token);

        $response->assertStatus(200);
        $response->assertJson(["success" => true]);

        $dataUtil->cleanUp();
    }

    /**
     * @test
     */
    public function testCheckInvalidApiToken() {
        $response = $this->get("/api/v1/check_api_token?api_token=" . str_random(30));

        $response->assertStatus(401);
        $response->assertJson(["success" => false]);
    }
}