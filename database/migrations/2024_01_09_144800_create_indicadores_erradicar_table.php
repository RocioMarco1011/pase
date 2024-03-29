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
    Schema::create('indicadores_erradicar', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('objetivo');
        $table->text('definicion');
        $table->text('variables'); 
        $table->text('observaciones')->nullable();
        $table->string('medios_verificacion', 500);
        $table->enum('parametro_meta', ['Parametro', 'Meta']);
        $table->enum('unidad_medida', ['Porcentaje', 'Promedio', 'Proporcion']);
        $table->enum('nivel_desagregacion', ['Estatal', 'Otra']);
        $table->enum('acumulado_periodico', ['Acumulado', 'Periodico']);
        $table->enum('tendencia_esperada', ['Ascendente', 'Descendente']);
        $table->enum('frecuencia_medicion', ['Anual', 'Mensual', 'Semestral']);
        $table->enum('semaforo', ['Verde > 0 - Amarillo = 0 - Rojo < 0', 'Verde < 0 - Amarillo = 0 - Rojo > 0']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicadores_erradicar');
    }
};
