<?php
/**
 * Created by mxss
 * Date: 13.09.18
 * Time: 12:05
 */

namespace App\Http\Transformers\V1\User;

use App\User;
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
        return [
            'id'    => (int) $user->id,
            'email'  => $user->email,
            'login' => $user->login,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
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
}