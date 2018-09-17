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
    const Banned = -1;
    const None = 0;
    const User = 1;

    const Employee = 10;
}