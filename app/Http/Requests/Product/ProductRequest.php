<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:2|max:50',
            'model' => 'required|min:2|max:50',
            'material' => 'required|min:2|max:50',
            'size' => 'required|min:2|max:50',
            'code' => 'required|min:1|max:3',
            'price' => 'required|min:1|max:10',
            'discount' => 'nullable',
            'description' => 'nullable',
//            'images' => 'nullable|array|max:10',
//            'images.*' => 'image|max:2000'
            'images' => 'required|array|max:10,min:1',
            'images.*' => 'mimes:jpeg,png,jpg,svg|max:2048'

        ];
    }
}
