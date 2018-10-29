<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 27.10.18
 * Time: 15:41
 */

namespace App\Console\Commands\Homework;


use App\Models\Homework\InternHomework;
use App\Support\Enums\HomeworkStatus;
use App\Support\InternHomework\Util\InternHomeworkUtils;
use App\Support\Notifications\Notifiers\EmployeeNotifier;
use App\Support\Notifications\Notifiers\InternNotifier;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RefreshHomeworkData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:refresh_homeworks_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление статусов и т.д. всех домашек (через cron)';

    public function handle()
    {
        $homeworks = InternHomework::all();
        foreach ($homeworks as $homework) {
            $startDate = Carbon::parse($homework->homework->start_date);
            $deadline = Carbon::parse($homework->homework->deadline);

            switch ($homework->status) {
                case HomeworkStatus::getKey(HomeworkStatus::NotStarted):
                    if (Carbon::now() > $startDate) {
                        InternHomeworkUtils::changeStatus(
                            null,
                            $homework,
                            HomeworkStatus::getKey(HomeworkStatus::InProgress),
                            true
                        );
                        InternNotifier::notifyUserHomeworkStatusChanged($homework);
                    }
                    break;
                case HomeworkStatus::getKey(HomeworkStatus::InProgress):
                    if (Carbon::now() > $deadline) {
                        $isHomeworkFailed = strlen($homework->github_uri) < 1;
                        $homework = InternHomeworkUtils::changeStatus(
                            null,
                            $homework,
                            HomeworkStatus::getKey(
                                $isHomeworkFailed ?
                                    HomeworkStatus::Failed : HomeworkStatus::OnReview
                            ),
                            true
                        );
                        if ($isHomeworkFailed) {
                            EmployeeNotifier::notifyEmployeeHomeworkFailed($homework);
                        } else {
                            EmployeeNotifier::notifyEmployeeHomeworkOnReview($homework);
                        }
                    }
                    break;
            }
        }
    }
}