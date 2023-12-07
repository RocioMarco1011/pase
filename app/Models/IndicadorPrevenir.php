<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicadorPrevenir extends Model
{
    use HasFactory;

    protected $table = 'indicadores_prevenir';

    protected $fillable = [
        'nombre',
        'objetivo',
        'definicion',
        'observaciones',
        'medios_verificacion',
        'parametro_meta',
        'unidad_medida',
        'nivel_desagregacion',
        'acumulado_periodico',
        'tendencia_esperada',
        'frecuencia_medicion',
    ];

    public function calcularPrevenir()
    {
        return $this->hasOne(CalcularPrevenir::class);
    }
}

