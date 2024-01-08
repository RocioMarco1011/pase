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
        Schema::create('accion_atender', function (Blueprint $table) {
            $table->id();
            $table->string('accion');
            $table->enum('tipo', ['General', 'Especifica']);
            $table->string('dependencias_responsables', 500);
            $table->string('dependencias_coordinadoras',500);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accion_atender');
    }
};
