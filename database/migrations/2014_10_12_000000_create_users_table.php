<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user', 35);
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->string('num_id', 20)->unique();
            $table->unsignedInteger('phone')->nullable()->unique();
            $table->unsignedInteger('sex')->nullable();
            $table->string('email', 50)->unique();
            $table->string('password')->nullable();
            $table->string('confirm')->nullable();
            $table->string('international_id', 100)->nullable();
            $table->string('web', 100)->nullable();
            $table->unsignedInteger('club_id')->nullable();
            $table->string('birthdate', 15)->nullable();
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

        Schema::create('parejas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 70);
            $table->string('last_name', 70);
            $table->string('email', 70)->nullable();
            $table->string('birthdate', 15)->nullable();
            $table->unsignedInteger('sex')->nullable();
            $table->unsignedInteger('febd_num')->nullable()->unique();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
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
};
