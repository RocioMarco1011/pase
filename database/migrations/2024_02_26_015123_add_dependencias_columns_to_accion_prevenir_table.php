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
        Schema::table('accion_prevenir', function (Blueprint $table) {
            $table->json('dependencias_responsables_ids')->nullable();
            $table->json('dependencias_coordinadoras_ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accion_prevenir', function (Blueprint $table) {
            $table->dropColumn('dependencias_responsables_ids');
            $table->dropColumn('dependencias_coordinadoras_ids');
        });
    }
};
