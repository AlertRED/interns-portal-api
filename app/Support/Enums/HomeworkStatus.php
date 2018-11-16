<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 24.09.18
 * Time: 13:13
 */

namespace App\Support\Enums;

use BenSampo\Enum\Enum;

final class HomeworkStatus extends Enum
{
    const Failed = -1;
    const NotStarted = 0;
    const InProgress = 1;
    const OnReview = 2;
    const Finished = 3;

    /**
     * @param string $status
     * @return bool
     */
    public static function isStatusExists(string $status) {
        return in_array($status, HomeworkStatus::getKeys());
    }
}