<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Permisologia\Role::create([
            'name' => 'Representante',
            'slug' => 'Representante',
            'description' => 'Representante de Bailarines',
        ]);

        \App\Models\Permisologia\Role::create([
            'name' => 'Bailarin',
            'slug' => 'Bailarin',
            'description' => 'Perfil de Bailarines',
        ]);
    }
}
