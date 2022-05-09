<?php

namespace App\Modules\Rating\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRatingRequest extends FormRequest
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
            'employee_id' => 'bail|nullable|required_without:center_id|int|exists:admins,id',
            'center_id' => 'bail|nullable|int|exists:centers,id|required_without:employee_id',
            'rating' => 'bail|required|regex:/^\d+(\.\d{1,2})?$/',
            'comment' => 'bail|string',
        ];
    }
}
