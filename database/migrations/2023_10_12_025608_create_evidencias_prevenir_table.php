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
        Schema::create('evidencias_prevenir', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('mensaje')->nullable();
            $table->unsignedBigInteger('accion_prevenir_id');
            $table->foreign('accion_prevenir_id')->references('id')->on('accion_prevenir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias_prevenir');
    }
};
