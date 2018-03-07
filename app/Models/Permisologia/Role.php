<?php

namespace App\Models\Permisologia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HelpersModelTrait;

class Role extends Model
{
	use SoftDeletes, HelpersModelTrait;

	protected $fillable = [
		'name', 'slug', 'description', 'from_at', 'to_at', 'special'
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
        'created_at' , 'updated_at', 'deleted_at'
    ];

    protected $seachable = [
        'id', 'name', 'slug', 'description', 'special'
    ];

	public function users()
	{
		return $this->belongsToMany(\App\User::class)->withTimestamps(); //->withTimestamps()
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class);
	}
}
