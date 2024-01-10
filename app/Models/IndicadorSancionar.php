<?php

// app/Models/IndicadorSancionar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicadorSancionar extends Model
{
    use HasFactory;

    protected $table = 'indicadores_sancionar';

    protected $fillable = [
        'nombre',
        'objetivo',
        'definicion',
        'variables',
        'observaciones',
        'medios_verificacion',
        'parametro_meta',
        'unidad_medida',
        'nivel_desagregacion',
        'acumulado_periodico',
        'tendencia_esperada',
        'frecuencia_medicion',
        'semaforo',
    ];

    public function calcularSancionar()
    {
        return $this->hasOne(CalcularSancionar::class);
    }
}
