<?php

namespace App\Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTrainingRequest extends FormRequest
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
            'center_id' => 'bail|required|int|exists:centers,id',
            'name' => 'bail|required|string',
            'name_ar' => 'bail|required|string',
            'description' => 'bail|required|string',
            'description_ar' => 'bail|required|string',
            'start_date' => 'bail|required|date_format:Y-m-d H:i',
        ];
    }
}
