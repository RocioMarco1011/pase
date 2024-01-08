<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('accion_atender', function (Blueprint $table) {
            $table->unsignedBigInteger('estrategia_id');
            $table->foreign('estrategia_id')->references('id')->on('estrategias_atenders');
        });
    }

    public function down()
    {
        Schema::table('accion_atender', function (Blueprint $table) {
            $table->dropForeign(['estrategia_id']);
            $table->dropColumn('estrategia_id');
        });
    }
};
