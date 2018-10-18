<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 18.10.18
 * Time: 12:30
 */

namespace App\Console\Commands\Temp;

use App\Support\Notifications\Notification;
use Queue;
use Illuminate\Console\Command;

class TempCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:test';

    /**
     *
     */
    public function handle() {
        $notification = new Notification("title here", "text here", "");
        Queue::pushOn('notification', $notification);
    }
}