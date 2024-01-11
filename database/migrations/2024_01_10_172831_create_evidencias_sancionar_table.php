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
    Schema::create('evidencias_sancionar', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('mensaje')->nullable();
        $table->string('archivo')->nullable();
        $table->foreignId('user_id')->constrained('users');
        $table->unsignedBigInteger('accion_sancionar_id');
        $table->foreign('accion_sancionar_id')->references('id')->on('accion_sancionar');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias_sancionar');
    }
};
