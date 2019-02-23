<?php
/**
 * Created by Max Kovalenko.
 * User: mxss
 * Date: 21.02.19
 * Time: 17:07
 */

namespace App\Console\Commands\Homework;


use App\Support\Sync\Homework\InternHomeworkSync;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HomeworkSync extends Command
{
    /**
     * @var string
     */
    protected $signature = "sync:all_homeworks";

    public function handle() {
        dd(Carbon::parse("2019-02-21T09:00:00.000Z"));
        InternHomeworkSync::syncAllInternHomeworks();
    }
}