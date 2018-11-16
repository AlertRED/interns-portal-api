<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 24.09.18
 * Time: 11:07
 */

namespace App\Http\Transformers\V1\Homework;

use App\Models\Homework\Homework;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class HomeworkTransformer extends TransformerAbstract
{
    /**
     * @var bool
     */
    private $hideUrl = false;

    /**
     * HomeworkTransformer constructor.
     * @param bool $hideUrl
     */
    public function __construct(bool $hideUrl = false) {
        $this->hideUrl = $hideUrl;
    }

    /**
     * @param Homework $item
     * @return array
     */
    public function transform(Homework $item) {
        $urlHidden = $this->hideUrl && Carbon::now() < Carbon::parse($item->start_date);
        return [
            'id' => (int)$item->id,
            'name' => $item->name,
            'number' => (int)$item->number,
            'course_id' => (int)$item->course_id,
            'url' => $urlHidden ? "" : $item->url,
            'deadline' => (string)$item->deadline,
            'start_date' => (string)$item->start_date,
            'created_at' => (string)$item->created_at
        ];
    }

    /**
     * @param Homework $item
     * @param $resourceKey
     * @param bool $hideUrl
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformItem(Homework $item, $resourceKey = null, $hideUrl = false)
    {
        return fractal()
            ->item($item, new HomeworkTransformer($hideUrl))
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }

    /**
     * @param Collection $items
     * @param $resourceKey
     * @param bool $hideUrl
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformCollection(Collection $items, $resourceKey = null, $hideUrl = false)
    {
        return fractal()
            ->collection($items, new HomeworkTransformer($hideUrl))
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }
}