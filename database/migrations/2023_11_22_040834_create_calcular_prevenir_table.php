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
        Schema::create('calcular_prevenir', function (Blueprint $table) {
            $table->id();
            $table->string('formula');
        
            
            $table->foreignId('indicador_prevenir_id')->constrained('indicadores_prevenir');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calcular_prevenir');
    }
};
