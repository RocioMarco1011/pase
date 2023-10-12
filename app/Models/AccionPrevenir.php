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

    // Define el tipo de datos para el campo 'tipo' como un enum
    protected $casts = [
        'tipo' => EnumCast::class.':'.TipoAccionEnum::class,
    ];
}

