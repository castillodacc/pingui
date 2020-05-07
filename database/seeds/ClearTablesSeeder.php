<?php

use Illuminate\Database\Seeder;

class ClearTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();

        DB::table('parejas')->truncate();

        DB::table('password_resets')->truncate();

        DB::table('clubs')->truncate();

        DB::table('referees')->truncate();

        DB::table('category_opens')->truncate();
        DB::table('category_latinos')->truncate();
        DB::table('subcategory_latinos')->truncate();
        DB::table('category_standars')->truncate();
        DB::table('subcategory_standars')->truncate();

        DB::table('organizers')->truncate();

        DB::table('tournaments')->truncate();
        DB::table('referee_tournament')->truncate();
        DB::table('category_open_tournament')->truncate();
        DB::table('subcategory_latino_tournament')->truncate();
        DB::table('subcategory_standar_tournament')->truncate();
        DB::table('hotels')->truncate();
        DB::table('prices')->truncate();
        DB::table('more_infos')->truncate();
        DB::table('inscriptions')->truncate();
        DB::table('inscription_price')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    }
}
    