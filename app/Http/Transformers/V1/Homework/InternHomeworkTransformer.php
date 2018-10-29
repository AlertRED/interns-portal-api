<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 25.09.18
 * Time: 12:37
 */

namespace App\Http\Transformers\V1\Homework;

use App\Models\Homework\InternHomework;
use App\Support\Lang\HomeworkStatusesLang;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class InternHomeworkTransformer extends TransformerAbstract
{
    /**
     * @param InternHomework $item
     * @return array
     */
    public function transform(InternHomework $item)
    {
        return [
            'id' => (int)$item->id,
            'user_id' => (int)$item->user_id,
            'homework' => HomeworkTransformer::transformItem($item->homework),
            'github_uri' => $item->github_uri,
            'status' => HomeworkStatusesLang::getTranslated($item->status),
            'started_at' => (string) $item->started_at,
            'created_at' => (string) $item->created_at
        ];
    }

    /**
     * @param InternHomework $item
     * @param $resourceKey
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformItem(InternHomework $item, $resourceKey = null)
    {
        return fractal()
            ->item($item, new InternHomeworkTransformer())
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
            ->collection($items, new InternHomeworkTransformer())
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }
}