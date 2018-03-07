<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolUpdateRequest extends FormRequest
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
            'name' => 'required|min:3|max:35',
            'slug' => 'required|min:3|max:35',
            'description' => 'nullable|string',
            'from_at' => 'nullable|hour_corret',
            'to_at' => 'nullable|hour_corret',
            'special' => 'nullable|string',
            'permissions' => 'nullable|array'
        ];
    }
}
