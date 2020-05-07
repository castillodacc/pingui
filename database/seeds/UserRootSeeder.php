<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        $user = App\User::create([
            'user'      => 'Root',
            'name'      => 'Root',
            'last_name' => 'Root',
            'num_id'    => '99999999',
            'email'     => 'root@pingui.es',
            'password'  => bcrypt('secret'),
        ]);

        $rol = App\Models\Permisologia\Role::create([
            'name'          => 'Administrador',
            'slug'          => 'SuperAdmin',
            'description'   => 'Acceso total a los Modulos.',
            'from_at'       => null,
            'to_at'         => null,
            'special'       => 'all-access'
        ]);

        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $rol->id
        ]);

        $num = App\Models\Permisologia\Permission::all()->count();
        $data = [];
        $data2 = [];
        for ($i = 1; $i <= $num; $i++) { 
            $data[] = ['role_id' => 1, 'permission_id' => $i];
            $data2[] = ['user_id' => $user->id, 'permission_id' => $i];
        }
        DB::table('permission_role')->insert($data);
        DB::table('permission_user')->insert($data2);
    }
}
