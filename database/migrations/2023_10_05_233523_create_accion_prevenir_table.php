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
    Schema::create('accion_prevenir', function (Blueprint $table) {
        $table->id();
        $table->string('accion');
        $table->enum('tipo', ['general', 'especifica']);
        $table->string('dependencias_responsables');
        $table->string('dependencias_coordinadoras');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accion_prevenir');
    }
};
