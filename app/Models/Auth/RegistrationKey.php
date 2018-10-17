<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 11:21
 */

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Auth\RegistrationKey
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $key
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereUserId($value)
 * @property int $is_used
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereIsUsed($value)
 * @property string $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereRole($value)
 * @property int|null $course_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Auth\RegistrationKey whereCourseId($value)
 */
class RegistrationKey extends Model
{
    /**
     * @var string
     */
    protected $table = "registration_keys";

    /**
     * @var array
     */
    protected $guarded = [];
}