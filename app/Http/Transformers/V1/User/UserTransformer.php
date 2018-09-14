<?php
/**
 * Created by mxss
 * Date: 13.09.18
 * Time: 12:05
 */

namespace App\Http\Transformers\V1\User;

use App\User;
use League\Fractal\TransformerAbstract;

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
}