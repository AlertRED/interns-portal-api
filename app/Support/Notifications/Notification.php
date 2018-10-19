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
    private $receiver;

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
    private $mailData;

    /**
     * @var array
     */
    private $notificationTypes;

    /**
     * Notification constructor.
     * @param string $title
     * @param User|null $receiver
     * @param string $text
     * @param array $notificationTypes
     * @param array $data
     * example -> ["app", "email"]
     * @param array $mailData
     */
    public function __construct(
        string $title, User $receiver, string $text = "", array $notificationTypes = [], array $data = [], array $mailData = []
    ) {
        $this->title = $title;
        $this->receiver = $receiver;
        $this->text = $text;
        $this->notificationTypes = $notificationTypes;
        $this->date = Carbon::now();
        $this->data = $data;
        $this->mailData = $mailData;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text) {
       $this->text = $text;
    }

    /**
     * @return User|null
     */
    public function getReceiver() {
        return $this->receiver;
    }

    /**
     * @param User $user
     */
    public function setReceiver(User $user) {
        $this->receiver = $user;
    }

    /**
     * @return Carbon
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date) {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data) {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getMailData() {
        return $this->mailData;
    }

    /**
     * @param array $data
     */
    public function setMailData(array $data) {
        $this->mailData = $data;
    }

    /**
     * @return array
     */
    public function getNotificationTypes() {
        return $this->notificationTypes;
    }

    /**
     * @param array $types
     */
    public function setNotificationTypes(array $types) {
        $this->notificationTypes = $types;
    }
}