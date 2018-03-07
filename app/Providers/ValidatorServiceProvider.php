<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;

class ValidatorServiceProvider extends ServiceProvider
{

    /**
     * Register validations directives.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('foo', function($attribute, $value, $parameters)
        {
            return $value == 'foo';
        });

        /**
         * validacion por expresion regular de una cedula de identidad.
         * de 6 a 8 caracteres
         * y solo numeros del 0 al 9
         */
        Validator::extend('exr_ced', function($attribute, $value)
        {
            if ($value[0] == '0') return false;
            return preg_match('/^([0-9]{6,8})$/', $value);
        }, 'El campo :attribute es incorrecto');

        /**
         * Comprueba que sea la contraseña actual del usuario autentificado.
         */
        Validator::extend('current_password', function($attribute, $value)
        {
            return Hash::check($value, Auth::user()->password);
        }, 'El campo :attribute no coincide con su contraseña actual.');

        /**
         * Verifica si existe el email que se registrara en una lista blanca.
         */
        Validator::extend('ValidEmailDomain', function($attribute, $value)
        {
            if (str_contains($value, '@')) {
                $domain = explode('@', $value)[1];
                $domains = [
                    'sahum.gob.ve', 'gmail.com',
                    'hotmail.com', 'outlook.com',
                    'yahoo.com', 'mail.com',
                ];
                return in_array($domain, $domains);
            }
        }, 'El dominio de tu email no es permitido.');

        /**
         * Verifiva que la hora este dentro del rango correcto.
         */
        Validator::extend('hour_corret', function($attribute, $value)
        {
            $sections = explode(':', $value);

            if (count($sections) === 3)
                if ($sections[0] >= 0 && $sections[0] <= 23)
                    if ($sections[1] >= 0 && $sections[1] <= 59)
                        if ($sections[2] >= 0 && $sections[2] <= 59) return true;
                    return false;
                }, 'El campo :attribute no posee un formato correcto.');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
