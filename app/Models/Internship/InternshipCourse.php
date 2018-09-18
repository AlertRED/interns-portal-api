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
 */
class InternshipCourse extends Model
{
    protected $table = "internship_courses";
}