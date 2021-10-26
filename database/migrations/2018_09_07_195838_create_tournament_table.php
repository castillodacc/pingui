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
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 150)->nullable()->unique();
            $table->text('description')->nullable();
            $table->date('start');
            $table->date('end');
            $table->boolean('inscription')->default(0);
            $table->string('image', 100)->nullable()->unique(); // ruta a imagen
            $table->string('results', 100)->nullable()->unique(); // ruta a resultados https://results.pingui.es/events.php?pod_id=%aca%
            $table->boolean('show_hour')->default(0);
            $table->string('hours')->nullable(); // ruta a pdf
            $table->string('maps')->nullable(); // ruta a google maps
            $table->string('info')->nullable(); // ruta al pdf de la hoja informativa
            $table->unsignedBigInteger('organizer_id');
            $table->unsignedBigInteger('record_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('record_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete('cascade');
        });

        Schema::create('referee_tournament', function (Blueprint $table) {
            $table->unsignedBigInteger('referee_id');
            $table->unsignedBigInteger('tournament_id');

            $table->foreign('referee_id')->references('id')->on('referees')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('category_open_tournament', function (Blueprint $table) {
            $table->unsignedBigInteger('category_open_id');
            $table->unsignedBigInteger('tournament_id');

            $table->foreign('category_open_id')->references('id')->on('category_opens')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('subcategory_latino_tournament', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_latino_id');
            $table->unsignedBigInteger('tournament_id');

            $table->foreign('subcategory_latino_id')->references('id')->on('subcategory_latinos')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('subcategory_standar_tournament', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_standar_id');
            $table->unsignedBigInteger('tournament_id');

            $table->foreign('subcategory_standar_id')->references('id')->on('subcategory_standars')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('link', 100);
            $table->unsignedBigInteger('tournament_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedBigInteger('tournament_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('more_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->unsignedBigInteger('type_id');
            $table->string('link', 150);
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('tournament_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tournament_id');

            $table->unsignedInteger('dorsal')->nullable();

            $table->unsignedInteger('febd_num_1')->nullable();
            $table->string('name_1', 150);
            $table->string('last_name_1', 150);
            $table->unsignedInteger('febd_num_2')->nullable();
            $table->string('name_2', 150);
            $table->string('last_name_2', 150);

            $table->unsignedInteger('pay');
            // $table->unsignedInteger('price');
            $table->unsignedInteger('method_pay'); // 1-transferencia 2-paypal

            $table->unsignedInteger('state_pay')->nullable(); // 1 aprobado - null no aprobado
            $table->unsignedInteger('state')->nullable(); // 1 aprobado - null no aprobado
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });

        Schema::create('inscription_price', function (Blueprint $table) {
            $table->unsignedBigInteger('price_id');
            $table->unsignedBigInteger('inscription_id');

            $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');
            $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('cascade');
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
        Schema::dropIfExists('inscription_price');
        Schema::dropIfExists('prices');
        Schema::dropIfExists('tournaments');
    }
}
