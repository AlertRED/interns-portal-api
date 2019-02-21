<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 24.09.18
 * Time: 10:51
 */

namespace App\Models\Homework;

use App\Support\Enums\HomeworkStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Homework\InternHomework
 *
 * @property int $id
 * @property int $user_id
 * @property int $homework_id
 * @property string $github_uri
 * @property string $status
 * @property string $started_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereGithubUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereHomeworkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Homework\Homework $homework
 * @property-read \App\User $user
 * @property int $score
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\InternHomework query()
 */
class InternHomework extends Model
{
    /**
     * @var string
     */
    protected $table = "intern_homeworks";

    /**
     * @var array
     */
    protected $guarded = ["id"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function homework()
    {
        return $this->hasOne("App\Models\Homework\Homework", "id", "homework_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne("App\User", "id", "user_id");
    }

    /**
     * @return mixed
     */
    public function getCourse() {
        return $this->homework->course;
    }

    /**
     * @param Collection $items
     * @return Collection
     */
    public static function filterActive(Collection $items) {
       return $items->filter(function ($item) {
           return Carbon::now() < Carbon::parse($item->homework->deadline);
       });
    }

    /**
     * @param Collection $items
     * @return Collection
     */
    public static function filterInActive(Collection $items) {
       return $items->filter(function ($item) {
           return Carbon::now() > Carbon::parse($item->homework->deadline);
       });
    }

    /**
     * @return string
     */
    public static function getDefaultStatus() {
        return HomeworkStatus::getKey(HomeworkStatus::NotStarted);
    }
}