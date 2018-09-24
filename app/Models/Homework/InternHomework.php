<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 24.09.18
 * Time: 10:51
 */

namespace App\Models\Homework;

use Illuminate\Database\Eloquent\Model;

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
}