<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_opens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 70)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_latinos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 70)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subcategory_latinos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 70);
            $table->text('description')->nullable();
            $table->unsignedInteger('category_latino_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_latino_id')->references('id')->on('category_latinos')->onDelete('cascade');
        });

        Schema::create('category_standars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 70)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subcategory_standars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 70);
            $table->text('description')->nullable();
            $table->unsignedInteger('category_standar_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_standar_id')->references('id')->on('category_standars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_opens');
        Schema::dropIfExists('subcategory_latinos');
        Schema::dropIfExists('category_latinos');
        Schema::dropIfExists('subcategory_standars');
        Schema::dropIfExists('category_standars');
    }
}
