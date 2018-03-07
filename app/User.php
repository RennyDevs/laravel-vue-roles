<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ {HelpersModelTrait, PermissionTrait };

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HelpersModelTrait, PermissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'name', 'last_name', 'num_id', 'email', 'module_id', 'password'
    ];

    /**
     * Los atruburos que seran instancia de carbon por ser tipo fecha.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Los atributos serian buscados al mostrar la tabla.
     *
     * @var array
     */
    protected $seachable = [
        'id', 'user', 'name', 'last_name', 'num_id', 'email', 'password'
    ];

    /**
     * Obtener el modulo que posee el usuario.
     */
    public function module()
    {
        // pertenece a
        return $this->belongsTo(Models\Module::class);
    }

    /**
     * Obtener los roles que posee el usuario.
     */
    public function roles()
    {
        // pertenece a muchas
        return $this->belongsToMany(Models\Permisologia\Role::class);
    }

    /**
     * Obtener los permisos que posee el usuario.
     */
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permisologia\Permission::class);
    }
}
