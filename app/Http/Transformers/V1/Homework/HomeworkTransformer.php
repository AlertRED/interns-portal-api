<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 24.09.18
 * Time: 11:07
 */

namespace App\Http\Transformers\V1\Homework;

use App\Models\Homework\Homework;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class HomeworkTransformer extends TransformerAbstract
{
    /**
     * @param Homework $item
     * @return array
     */
    public function transform(Homework $item)
    {
        return [
            'id'         => (int)$item->id,
            'name'       => $item->name,
            'number'     => (int)$item->number,
            'course_id'  => (int)$item->course_id,
            'url'        => $item->url,
            'deadline'   => (string)$item->deadline,
            'created_at' => (string)$item->created_at
        ];
    }

    /**
     * @param Homework $item
     * @param $resourceKey
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformItem(Homework $item, $resourceKey = null)
    {
        return fractal()
            ->item($item, new HomeworkTransformer())
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
            ->collection($items, new HomeworkTransformer())
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }
}