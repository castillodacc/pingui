<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->string('slug', 150)->nullable()->unique();
            $table->text('description')->nullable();
            $table->date('start');
            $table->date('end');
            $table->boolean('inscription')->default(0);
            $table->string('image', 100)->nullable()->unique(); // ruta a imagen
            $table->string('results', 100)->nullable()->unique(); // ruta a resultados https://results.pingui.es/events.php?pod_id=%aca%
            $table->text('hours')->nullable(); // ruta a pdf
            $table->text('maps')->nullable(); // ruta a google maps
            $table->text('info')->nullable(); // ruta al pdf de la hoja informativa
            // $table->unsignedInteger('price');
            // $table->unsignedInteger('entrance_price');
            $table->unsignedInteger('organizer_id');
            $table->unsignedInteger('record_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('record_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete('cascade');
        });

        Schema::create('inscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tournament_id');
            $table->unsignedInteger('febd_num_1');
            $table->unsignedInteger('name_1');
            $table->unsignedInteger('last_name_1');
            $table->unsignedInteger('febd_num_2');
            $table->unsignedInteger('name_2');
            $table->unsignedInteger('last_name_2');
            $table->unsignedInteger('type_pay');
            $table->unsignedInteger('state_pay');
            $table->unsignedInteger('state');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('referee_tournament', function (Blueprint $table) {
            $table->unsignedInteger('referee_id');
            $table->unsignedInteger('tournament_id');

            $table->foreign('referee_id')->references('id')->on('referees')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('category_open_tournament', function (Blueprint $table) {
            $table->unsignedInteger('category_open_id');
            $table->unsignedInteger('tournament_id');

            $table->foreign('category_open_id')->references('id')->on('category_opens')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('subcategory_latino_tournament', function (Blueprint $table) {
            $table->unsignedInteger('subcategory_latino_id');
            $table->unsignedInteger('tournament_id');

            $table->foreign('subcategory_latino_id')->references('id')->on('subcategory_latinos')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('subcategory_standar_tournament', function (Blueprint $table) {
            $table->unsignedInteger('subcategory_standar_id');
            $table->unsignedInteger('tournament_id');

            $table->foreign('subcategory_standar_id')->references('id')->on('subcategory_standars')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('link', 100);
            $table->unsignedInteger('tournament_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('price', 100);
            $table->unsignedInteger('tournament_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptions');
        Schema::dropIfExists('referee_tournament');
        Schema::dropIfExists('category_open_tournament');
        Schema::dropIfExists('subcategory_latino_tournament');
        Schema::dropIfExists('subcategory_standar_tournament');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('prices');
        Schema::dropIfExists('tournaments');
    }
}
