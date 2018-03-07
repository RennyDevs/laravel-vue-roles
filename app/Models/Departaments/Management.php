<?php

namespace App\Models\Departaments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Management extends Model
{
	use SoftDeletes;

	protected $fillable = ['management'];

	protected $hidden = [
		'created_at' , 'updated_at', 'deleted_at'
	];

	/**
	 * Obtener las divisiones que posee la direccion
	 */
	public function divisions()
	{
		return $this->hasMany(Division::class);
	}
}