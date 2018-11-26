<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 11:42
 */

namespace App\Support\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Banned = "Banned";
    const None = "None";
    const User = "User";

    const Employee = "Employee";

    const Admin = "Admin";
}