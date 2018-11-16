<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 10.10.18
 * Time: 12:38
 */

namespace App\Repositories\Auth;


use App\Models\Auth\RegistrationKey;

class RegistrationKeyRepository
{
    /**
     * @param RegistrationKey $key
     * @param array $data
     */
    public static function update(RegistrationKey $key, array $data) {
        $key->update($data);
    }
}