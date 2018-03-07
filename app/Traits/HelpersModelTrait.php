<?php

namespace App\Traits;

use App\Models\Permisologia\Role;

trait HelpersModelTrait
{
	public function update_pivot(Array $roles = [], $enlace, $campo)
	{
		$user_roles = $this->$enlace()->pluck($campo)->toArray();
		$add    = array_diff($roles, $user_roles);
		$delete = array_diff($user_roles, $roles);
		if(!empty($add)) $this->$enlace()->attach($add);
		if (!empty($delete)) $this->$enlace()->detach($delete);
		return true;
	}

	public function arrayOf($enlace, $campo = 'id')
	{
		return $this->$enlace()->pluck($campo)->toArray();
	}

	public function permissionsOfUser($module)
	{
		if ($this->id == 1) return 'all-access';
		$permissions = [];
		foreach ($this->roles as $rol) {
			if ($rol->special == 'all-access') return $rol->special;
			if ($rol->special == 'no-access') return [];
		}
		return $this->permissions->where('module', '=', $module)->pluck('action');
	}

	public function scopeSearch($query, $keyword = '')
	{
		if (empty($keyword)) return $query;

		$words = explode(' ', $keyword);
		foreach ($this->seachable as $column) {
			foreach ($words as $word) {
				$query->orWhere($column, 'like', "%{$word}%");
			}
		}
		return $query;
	}

	public function assignPermissionsOneUser($roles)
	{
		$permissions = [];
		foreach ($roles as $rol) {
			$permissionsOfRol = Role::findOrFail($rol)->arrayOf('permissions', 'permission_id');
			$permissions = array_merge($permissions, $permissionsOfRol);
		}
		return $this->update_pivot(array_unique($permissions), 'permissions', 'permission_id');
	}

	public function assignPermissionsAllUser()
	{
		$permissions = $this->arrayOf('permissions', 'permission_id');
		foreach ($this->users as $user) {
			$user->update_pivot($permissions, 'permissions', 'permission_id');
		}
		return true;
	}
}