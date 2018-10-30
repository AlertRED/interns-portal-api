<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 29.10.18
 * Time: 17:44
 */

namespace App\Support\Lang;

/**
 * TODO: update using lang in laravel
 * Class HomeworkStatusesLang
 * @package App\Support\Lang
 */
class HomeworkStatusesLang
{
    /**
     * @param string $translated
     * @return int|string
     */
    public static function getSource(string $translated) {
        foreach (self::getLang() as $source => $word) {
            if ($translated == $word) {
                return $source;
            }
        }
        return null;
    }

    /**
     * @param string $baseWord
     * @return int|string
     */
    public static function getTranslated(string $baseWord) {
        foreach (self::getLang() as $source => $word) {
            if ($baseWord == $source) {
                return $word;
            }
        }
        return null;
    }

    /**
     * @return array
     */
    private static function getLang() {
        return [
            "Failed" => "Провалено",
            "NotStarted" => "Не началось",
            "InProgress" => "В работе",
            "OnReview" => "На проверке",
            "Finished" => "Выполнено"
        ];
    }
}