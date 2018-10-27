<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 26.10.18
 * Time: 17:59
 */

namespace App\Repositories\Homework;

use App\Models\Homework\InternHomework;

class InternHomeworkRepository
{
    /**
     * @param InternHomework $item
     * @param array $data
     * @return InternHomework
     */
    public static function update(InternHomework $item,array $data) {
        $item->update([
            "status" => isset($data["status"]) ? $data["status"] : $item->status,
            "github_uri" => isset($data["github_uri"]) ? $data["github_uri"] : $item->github_uri
        ]);
        return $item;
    }
}