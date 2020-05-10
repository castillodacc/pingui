<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInscriptionOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscription_onlines', function (Blueprint $table) {
            $table->string('dance')->nullable();
            $table->string('age_group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscription_onlines', function (Blueprint $table) {
            $table->dropColumn('dance');
            $table->dropColumn('age_group');
        });
    }
}
