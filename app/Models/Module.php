<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
	use SoftDeletes;

	protected $fillable = ['name'];

    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    /**
	 * Obtener los usuarios que posee el modulo
     */
	public function users()
	{
        // tiene muchas
		return $this->hasMany(\App\User::class);
	}
}
