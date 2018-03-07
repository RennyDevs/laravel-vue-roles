<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
  /**
   * Sección de permisos que manejara la app.
   *
   * @return void
   */
  public function run()
  {
    /**
     * Permisos de Modulos
     */
    App\Models\Permisologia\Permission::create([
      'name' => 'Cambiar de Modulo',
      'module' => 'module',
      'action' => 'changeModule',
      'description' => 'Permiso para cambiar de modulo'
    ]);

    /**
     * Permisos de usuarios
     */
    App\Models\Permisologia\Permission::create([
      'name' => 'Ver Usuarios',
      'module' => 'user',
      'action' => 'index',
      'description' => 'Permiso para Ver usuarios'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Ver Usuario',
      'module' => 'user',
      'action' => 'show',
      'description' => 'Permiso para Ver usuario'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'form de Usuario',
      'module' => 'user',
      'action' => 'create',
      'description' => 'Permiso para ver el formulario usuario'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Editar Usuarios',
      'module' => 'user',
      'action' => 'update',
      'description' => 'Permiso para editar usuarios'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Crear Usuarios',
      'module' => 'user',
      'action' => 'store',
      'description' => 'Permiso para crear usuarios'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Borrar Usuarios',
      'module' => 'user',
      'action' => 'destroy',
      'description' => 'Permiso para borrar usuarios'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Restaurar Usuario',
      'module' => 'user',
      'action' => 'restore',
      'description' => 'Permiso para Restaurar Usuario borrado'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Cambiar usuario',
      'module' => 'user',
      'action' => 'initWithOneUser',
      'description' => 'Permiso para Iniciar sesion con otro usuario'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Editar Contraseñas',
      'module' => 'user',
      'action' => 'editPassword',
      'description' => 'Permiso para Editar contraseñas de otro usuario'
    ]);

    /**
     * Permisos de Roles
     */
    App\Models\Permisologia\Permission::create([
      'name' => 'Ver Roles',
      'module' => 'rol',
      'action' => 'index',
      'description' => 'Permiso para ver roles'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Crear Roles',
      'module' => 'rol',
      'action' => 'create',
      'description' => 'Permiso para Crear roles'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Actualizar Roles',
      'module' => 'rol',
      'action' => 'update',
      'description' => 'Permiso para actualizar roles'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Eliminar Roles',
      'module' => 'rol',
      'action' => 'destroy',
      'description' => 'Permiso para Eliminar roles'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Restaurar Roles',
      'module' => 'rol',
      'action' => 'restore',
      'description' => 'Permiso para Restaurar roles'
    ]);

    /**
     * Permisos de Permisos
     */
    App\Models\Permisologia\Permission::create([
      'name' => 'Ver Permisos',
      'module' => 'permission',
      'action' => 'index',
      'description' => 'Permiso para Ver Permisos'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Modificar Permisos',
      'module' => 'permission',
      'action' => 'update',
      'description' => 'Permiso para Eliminar Permisos'
    ]);

    App\Models\Permisologia\Permission::create([
      'name' => 'Act/Des Permisos',
      'module' => 'permission',
      'action' => 'desActived',
      'description' => 'Permiso para Activar y Desactivar Permisos'
    ]);
  }
}
