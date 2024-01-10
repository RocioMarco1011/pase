<?php

// app/Models/IndicadorErradicar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicadorErradicar extends Model
{
    use HasFactory;

    protected $table = 'indicadores_erradicar';

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

    public function calcularErradicar()
    {
        return $this->hasOne(CalcularErradicar::class);
    }
}
