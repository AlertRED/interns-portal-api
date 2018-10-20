<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 20.10.18
 * Time: 18:20
 */

namespace App\Models\Notification;


use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Notification\AppNotification
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $seen
 * @property string $text
 * @property string $uri
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification\AppNotification whereUserId($value)
 * @mixin \Eloquent
 */
class AppNotification extends Model
{
    /**
     * @var
     */
    protected $table = "app_notifications";

    /**
     * @var array
     */
    protected $guarded = ["id"];
}