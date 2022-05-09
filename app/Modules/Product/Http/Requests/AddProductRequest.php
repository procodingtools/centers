<?php

namespace App\Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'name' => 'bail|required|string',
            'name_ar' => 'bail|required|string',
            'desc' => 'bail|required|string',
            'desc_ar' => 'bail|required|string',
            'center_id' => 'bail|int|exists:centers,id|required',
            'image' => 'bail|image|nullable',
            'qty' => 'bail|int|min:1',
        ];
    }
}
