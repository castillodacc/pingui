<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscriptionOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscription_onlines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('club')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('coach')->nullable();
            $table->string('country')->nullable();
            $table->string('birthdate')->nullable();
            $table->unsignedInteger('sex_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('inscription_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('inscription_id')->references('id')
            ->on('inscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscription_onlines');
    }
}
