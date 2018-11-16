<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 30.10.18
 * Time: 11:00
 */

namespace App\Jobs\HomeworkStatuses;

use App\Models\Homework\InternHomework;
use App\Support\Enums\HomeworkStatus;
use App\Support\InternHomework\Util\InternHomeworkUtils;
use App\Support\Notifications\Notifiers\EmployeeNotifier;
use App\Support\Notifications\Notifiers\InternNotifier;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateHomeworkStatusesJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle() {

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
                        InternHomeworkUtils::changeStatus(
                            null,
                            $homework,
                            HomeworkStatus::getKey(
                                $isHomeworkFailed ?
                                    HomeworkStatus::Failed : HomeworkStatus::OnReview
                            ),
                            true
                        );
                    }
                    break;
                case null:
                case "":
                    InternHomeworkUtils::changeStatus(
                        null,
                        $homework,
                        HomeworkStatus::getKey(HomeworkStatus::NotStarted),
                        true
                    );
                    break;
            }
        }
    }
}