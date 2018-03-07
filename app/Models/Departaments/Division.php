<?php

namespace App\Models\Departaments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
	use SoftDeletes;

	protected $fillable = ['division', 'management_id'];

	protected $hidden = [
		'created_at' , 'updated_at', 'deleted_at'
	];

	/**
	 * Obtener las direccion que posee la division
	 */
	public function management()
	{
		return $this->belongsTo(Management::class);
	}
}