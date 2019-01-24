<?php

namespace Tests\Unit\Support\Auth;

use App\Support\Auth\UserAuth;
use App\Support\Enums\UserType;
use App\Support\Tests\TestDataCreatorUtil;
use App\Support\User\Util\UserRoles;
use Tests\TestCase;

class UserAuthTests extends TestCase
{
    /**
     * A basic test example.
     *
     * @test
     * @return void
     * @throws \Exception
     */
    public function RegenApiToken_DataCorrect_Success()
    {
        $dataUtil = new TestDataCreatorUtil();
        $user = $dataUtil->getUser();

        $prevApiToken = $user->api_token;

        $user = UserAuth::regenUserAPIToken($user);

        $user->refresh();

        $this->assertTrue($prevApiToken != $user->api_token);

        $dataUtil->cleanUp();
    }

    /**
     * @test
     * @throws \Exception
     */
    public function UpdateUserRole_DataCorrect_Success()
    {
        $dataUtil = new TestDataCreatorUtil();
        $user = $dataUtil->getUser();

        $this->assertTrue($user->role == UserType::getKey(UserType::User));

        $user = UserRoles::updateUserRole($user, UserType::getKey(UserType::Employee));

        $this->assertTrue($user->role == UserType::getKey(UserType::Employee));

        $dataUtil->cleanUp();
    }
}
