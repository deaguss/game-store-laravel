<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillboardRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => 'required|image|dimensions:min_width=600,min_height=200',
            'description' => 'required|string|max:25, min:10',
            'label' => 'required|string|max:20, min:10',
        ];
    }
}
