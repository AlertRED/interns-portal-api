<?php
/**
 * Created by mxss
 * Date: 13.09.18
 * Time: 12:05
 */

namespace App\Http\Transformers\V1\Notification;

use App\Models\Notification\AppNotification;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class AppNotificationTransformer extends TransformerAbstract
{
    /**
     * @param AppNotification $item
     * @return array
     */
    public function transform(AppNotification $item)
    {
        return [
            'id' => (int)$item->id,
            'user_id' => (int)$item->user_id,
            'title' => $item->title,
            'seen' => (bool) $item->seen,
            'text' => $item->text,
            'uri' => $item->uri,
            'created_at' => (string) $item->created_at
        ];
    }

    /**
     * @param AppNotification $item
     * @param $resourceKey
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformItem(AppNotification $item, $resourceKey = null)
    {
        return fractal()
            ->item($item, new AppNotificationTransformer())
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }

    /**
     * @param Collection $items
     * @param $resourceKey
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformCollection(Collection $items, $resourceKey = null)
    {
        return fractal()
            ->collection($items, new AppNotificationTransformer())
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }
}