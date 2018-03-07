<?php

use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('users')->truncate();
        DB::table('modules')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        
        App\Models\Module::create(['module' => 'Ticket`s Otic']);
        App\Models\Module::create(['module' => 'Notificaciones de Aires']);
        App\Models\Module::create(['module' => 'Bienes Nacionales']);

        App\User::create([
            'user'      => 'root@sahum.gob.ve',
            'name'      => 'Root',
            'last_name' => 'Root',
            'num_id'    => '99999999',
            'email'     => 'root@sahum.gob.ve',
            'password'  => bcrypt('secret'),
            'module_id' => 1
        ]);

        App\Models\Permisologia\Role::create([
            'name'          => 'Super Administrador',
            'slug'          => 'SuperAdmin',
            'description'   => 'Acceso total a los Modulos.',
            'from_at'       => \Carbon\Carbon::parse('08:00:00'),
            'to_at'         => \Carbon\Carbon::parse('17:00:00'),
            'special'       => 'all-access'
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        factory(App\User::class, 99)->create();

        factory(App\Models\Permisologia\Role::class, 19)->create();

        $this->call(PermissionsSeeder::class);

        for ($i = 1; $i <= 18; $i++) { 
            DB::table('permission_user')->insert([
                'user_id' => 1,
                'permission_id' => $i,
                'created_at' => $now,
                'updated_at' => null
            ]);
        }

        for ($i = 1; $i <= 18; $i++) { 
            DB::table('permission_role')->insert([
                'role_id' => 1,
                'permission_id' => $i,
                'created_at' => $now,
                'updated_at' => null
            ]);
        }

        for ($i=2; $i <= 100; $i++) { 
            DB::table('role_user')->insert([
                'user_id' => $i,
                'role_id' => rand(2, 5),
                'created_at' => $now,
                'updated_at' => null
            ]);
        }
    }
}
