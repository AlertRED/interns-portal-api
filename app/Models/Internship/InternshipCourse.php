<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 18.09.18
 * Time: 10:27
 */

namespace App\Models\Internship;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Internship\InternshipCourse
 *
 * @property int $id
 * @property string $course
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\InternshipCourse whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\InternshipCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\InternshipCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\InternshipCourse whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Homework\Homework[] $homeworks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\InternshipCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\InternshipCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\InternshipCourse query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 */
class InternshipCourse extends Model
{
    /**
     * @var string
     */
    protected $table = "internship_courses";

    /**
     * @var array
     */
    protected $guarded = ["id"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function homeworks()
    {
        return $this->hasMany("App\Models\Homework\Homework", "course_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() {
        return $this->hasMany("App\User", "course_id");
    }
}