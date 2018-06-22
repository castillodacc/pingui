<?php

use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\Models\Module::create(['module' => 'Ticket`s Otic']);
    	App\Models\Module::create(['module' => 'Notificaciones de Aires']);
    	App\Models\Module::create(['module' => 'Bienes Nacionales']);
    }
}
