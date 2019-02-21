<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 22.11.18
 * Time: 15:10
 */

namespace App\Models\Permissions;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Permissions\CourseUserRight
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property string $right
 * @property int $allowed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight whereAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight whereRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Internship\InternshipCourse $course
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permissions\CourseUserRight query()
 */
class CourseUserRight extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string
     */
    protected $table = "course_user_rights";

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