<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'passwordold' => 'required|string|min:6|current_password', //alpha_dash
            'passwordnew' => 'required|string|min:6|confirmed|different:passwordold',
            // 'passwordnew_confirmation' => 'required|string|min:6' //same:passwordnew
        ];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'passwordold' => 'contraseña actual',
            'passwordnew' => 'contraseña nueva',
            'passwordnew_confirmation' => 'confirmacion de contraseña'
        ];
    }
}
