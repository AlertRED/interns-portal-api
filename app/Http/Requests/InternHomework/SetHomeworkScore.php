<?php

namespace App\Http\Requests\InternHomework;

use Illuminate\Foundation\Http\FormRequest;

class SetHomeworkScore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "score" => "required|integer|min:0|max:5"
        ];
    }
}
