<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user', 35);
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->unsignedInteger('num_id')->unique();
            $table->unsignedInteger('phone')->nullable()->unique();
            $table->string('email', 50)->unique();
            $table->string('password')->nullable();

            $table->string('international_id', 100)->nullable();
            $table->string('web', 100)->nullable();
            $table->unsignedInteger('club_id')->nullable();
            $table->unsignedInteger('febd_num')->nullable()->unique();
            $table->unsignedInteger('category_l')->nullable();
            $table->string('trainer_l', 50)->nullable();
            $table->unsignedInteger('category_s')->nullable();
            $table->string('trainer_s', 50)->nullable();
            $table->unsignedInteger('group_l')->nullable();
            $table->unsignedInteger('group_s')->nullable();

            // $table->unsignedInteger('approval_state')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        /*Schema::create('parejas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('febd_num')->nullable()->unique();
            $table->unsignedInteger('category_l')->nullable();
            $table->string('trainer_l', 50)->nullable();
            $table->unsignedInteger('category_s')->nullable();
            $table->string('trainer_s', 50)->nullable();
            $table->unsignedInteger('group_l')->nullable();
            $table->unsignedInteger('group_s')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
