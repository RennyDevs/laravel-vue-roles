<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'user'      => 'required|max:15|alpha_num',
            'name'      => 'required|alpha|min:3|max:25',
            'last_name' => 'required|alpha|min:3|max:25',
            'num_id'    => 'required|numeric|exr_ced',
            'email'     => 'required|email|max:50|ValidEmailDomain',
            'roles'     => 'required|array',
            'module_id' => 'required|numeric'
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
