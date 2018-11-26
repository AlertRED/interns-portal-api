<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 16.11.18
 * Time: 16:10
 */

namespace App\Models\Internship;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Internship\CourseLead
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\CourseLead whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\CourseLead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\CourseLead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\CourseLead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Internship\CourseLead whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Internship\InternshipCourse $course
 * @property-read \App\User $user
 */
class CourseLead extends Model
{
    /**
     * @var string
     */
    protected $table = "course_leads";

    /**
     * @var array
     */
    protected $guarded = ["id"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function course() {
        return $this->hasOne("App\Models\Internship\InternshipCourse", "id", "course_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne("App\User", "id", "user_id");
    }
}