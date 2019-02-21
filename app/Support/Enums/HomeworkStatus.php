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
    const Failed = "Failed";
    const NotStarted = "NotStarted";
    const InProgress = "InProgress";
    const OnReview = "OnReview";
    const Finished = "Finished";

    /**
     * @param string $status
     * @return bool
     */
    public static function isStatusExists(string $status) {
        return in_array($status, HomeworkStatus::getKeys());
    }
}