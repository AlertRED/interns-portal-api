<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 18.10.18
 * Time: 11:34
 */

namespace App\Jobs\Notifications;

use App\Support\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Notification
     */
    private $notification;

    /**
     * Create a new job instance.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     *
     */
    public function handle() {
        $notificationTypes = $this->notification;

        foreach ($notificationTypes as $notificationType) {
            error_log("notification processed!");
            try {
                switch ($notificationType) {
                    case "app":

                        break;
                    case "email":

                        break;
                }
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                \Log::error($e->getTraceAsString());
            }
        }
    }
}