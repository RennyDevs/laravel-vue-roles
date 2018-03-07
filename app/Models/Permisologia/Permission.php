<?php

namespace App\Models\Permisologia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HelpersModelTrait;

class Permission extends Model
{
	use SoftDeletes, HelpersModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'module', 'action', 'description', 'deleted_at'
	];

	/**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at'
    ];

    protected $seachable = [
        'id', 'name', 'module', 'action'
    ];

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

    /**
     * Obtener los permisos que posee el usuario.
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }
}
