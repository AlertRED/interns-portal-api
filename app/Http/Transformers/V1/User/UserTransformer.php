<?php
/**
 * Created by mxss
 * Date: 13.09.18
 * Time: 12:05
 */

namespace App\Http\Transformers\V1\User;

use App\Models\Internship\InternshipCourse;
use App\Support\User\Util\UserUtils;
use App\User;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class UserTransformer extends TransformerAbstract
{
    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        $course = InternshipCourse::find($user->course_id);
        return [
            'id'    => (int) $user->id,
            'email'  => $user->email,
            'login' => $user->login,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'course' => $course ? $course->course : null,
            'role' => $user->role,
            'avg_score' => UserUtils::getUserAverageHomeworkScore($user),
            'register_date' => (string) $user->created_at
        ];
    }

    /**
     * @param User $user
     * @param $resourceKey
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformItem(User $user, $resourceKey = null)
    {
        return fractal()
            ->item($user, new UserTransformer())
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }

    /**
     * @param Collection $users
     * @param $resourceKey
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformCollection(Collection $users, $resourceKey = null)
    {
        return fractal()
            ->collection($users, new UserTransformer())
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }
}