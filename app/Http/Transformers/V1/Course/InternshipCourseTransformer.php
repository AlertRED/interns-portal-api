<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 25.09.18
 * Time: 14:38
 */

namespace App\Http\Transformers\V1\Course;

use App\Http\Transformers\V1\User\UserTransformer;
use App\Models\Internship\InternshipCourse;
use App\Support\Courses\CoursesUtils;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class InternshipCourseTransformer extends TransformerAbstract
{
    /**
     * @param InternshipCourse $item
     * @return array
     */
    public function transform(InternshipCourse $item)
    {
        return [
            'id' => (int)$item->id,
            'course' => $item->course,
            "leads" => UserTransformer::transformCollection(CoursesUtils::getCourseLeads($item))
        ];
    }

    /**
     * @param InternshipCourse $item
     * @param $resourceKey
     * @return \Spatie\Fractal\Fractal
     */
    public static function transformItem(InternshipCourse $item, $resourceKey = null)
    {
        return fractal()
            ->item($item, new InternshipCourseTransformer())
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
            ->collection($items, new InternshipCourseTransformer())
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceKey);
    }
}