<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\Casts\EnumCast;
use App\Enums\TipoAccionEnum;

class AccionPrevenir extends Model
{
    use HasFactory;

    protected $table = 'accion_prevenir'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'accion',
        'tipo',
        'dependencias_responsables',
        'dependencias_coordinadoras',
        'estrategia_id',
    ];

    public function estrategiasPrevenir()
    {
        return $this->belongsTo(EstrategiasPrevenir::class, 'estrategia_id');
    }
}

