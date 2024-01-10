<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('calcular_erradicar', function (Blueprint $table) {
        $table->id();
        $table->string('formula');
        $table->json('variables')->nullable();
        $table->decimal('resultado', 10, 2)->nullable();
        $table->foreignId('user_id')->constrained('users');
        $table->foreignId('indicador_erradicar_id')->constrained('indicadores_erradicar'); 
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calcular_erradicar');
    }
};
