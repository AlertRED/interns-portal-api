<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 24.09.18
 * Time: 10:39
 */

namespace App\Models\Homework;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Homework\Homework
 *
 * @property int $id
 * @property int $number
 * @property string $url
 * @property int $course_id
 * @property string $deadline
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereUrl($value)
 * @mixin \Eloquent
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereName($value)
 * @property string|null $start_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Homework\Homework whereStartDate($value)
 * @property-read \App\Models\Internship\InternshipCourse $course
 */
class Homework extends Model
{
    /**
     * @var string
     */
    protected $table = "homeworks";

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function course() {
        return $this->hasOne("App\Models\Internship\InternshipCourse", "id", "course_id");
    }
}