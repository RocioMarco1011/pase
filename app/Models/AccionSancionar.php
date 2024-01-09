<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionSancionar extends Model
{
    use HasFactory;

    protected $table = 'accion_sancionar'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'accion',
        'tipo',
        'dependencias_responsables',
        'dependencias_coordinadoras',
        'estrategia_id',
    ];

    public function estrategiasSancionar()
    {
        return $this->belongsTo(EstrategiasSancionar::class, 'estrategia_id');
    }
}


