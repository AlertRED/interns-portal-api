<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 20.11.18
 * Time: 14:43
 */

namespace App\Support\Enums;

use BenSampo\Enum\Enum;

final class UserCourseRight extends Enum
{
    const ViewHomeworks = "ViewHomeworks";
    const EditHomeworks = "EditHomeworks";
    const ChangeHomeworkStatuses = "ChangeHomeworkStatuses";
}