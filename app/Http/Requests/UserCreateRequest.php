<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'user'      => 'required|unique:users|max:10|alpha_num',
            'name'      => 'required|alpha|max:15',
            'last_name' => 'required|alpha|max:15',
            'num_id'    => 'required|numeric|unique:users|min:500000|max:30000000',
            'email'     => 'required|email|min:6|max:50|unique:users|ValidEmailDomain',
            'password'  => 'required|string|min:6|max:20|confirmed',
            'roles'     => 'nullable|array',
            'module_id' => 'required|numeric'
        ];
    }

    /**
     * mensajes personalizados.
     *
     * @return array
     */
    public function messages()
    {
        return ['email.required' => 'El campo :attribute es requerido.'];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user'      => 'usuario',
            'name'      => 'nombre',
            'last_name' => 'apellido',
            'num_id'    => 'cedula',
            'email'     => 'correo',
            'password'  => 'contraseña',
            'module_id' => 'modulo'
        ];
    }
}
