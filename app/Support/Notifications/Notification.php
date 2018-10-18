<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 18.10.18
 * Time: 11:35
 */

namespace App\Support\Notifications;

use App\User;
use Carbon\Carbon;

class Notification
{
    /**
     * @var User
     */
    private $requester;

    /**
     * @var string
     */
    private $title;

    /**
     * @var
     */
    private $text;

    /**
     * @var Carbon
     */
    private $date;

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $notificationTypes;

    /**
     * Notification constructor.
     * @param string $title
     * @param string $text
     * @param User|null $requester
     * @param Carbon|null $date
     * @param array $data
     * example -> ["app", "email"]
     * @param array $notificationTypes
     */
    public function __construct(
        string $title, string $text = "", User $requester = null, Carbon $date = null, array $data = [],
        array $notificationTypes = []
    )
    {
        $this->text = $title;
        $this->text = $text;
        $this->requester = $requester;
        $this->date = $date ? $date : Carbon::now();
        $this->data = $data;
        $this->notificationTypes = $notificationTypes;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return User|null
     */
    public function getRequester()
    {
        return $this->requester;
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getNotificationTypes() {
        return $this->notificationTypes;
    }
}