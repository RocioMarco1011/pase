<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionErradicar extends Model
{
    use HasFactory;

    protected $table = 'accion_erradicar'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'accion',
        'tipo',
        'dependencias_responsables',
        'dependencias_coordinadoras',
        'estrategia_id',
    ];

    public function estrategiasErradicar()
    {
        return $this->belongsTo(EstrategiasErradicar::class, 'estrategia_id');
    }
}



