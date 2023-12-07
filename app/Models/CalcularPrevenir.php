<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CalcularPrevenirController;

class CalcularPrevenir extends Model
{
    use HasFactory;
    protected $table = 'calcular_prevenir';

    // Campos que pueden ser asignados masivamente (si estás utilizando fillable)
    protected $fillable = ['indicador_prevenir_id', 'formula', 'variables', 'resultado'];

    // Relación con el modelo IndicadorPrevenir (si es necesario)
    public function indicadorPrevenir()
    {
        return $this->belongsTo(IndicadorPrevenir::class, 'indicador_prevenir_id');
    }

}
