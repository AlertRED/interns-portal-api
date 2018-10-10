<?php

namespace App\Repositories\User;

use App\User;

class UserRepository
{
    /**
     * @param array $data
     * @return User
     */
    public static function create(array $data) {
        return User::create($data);
    }
}