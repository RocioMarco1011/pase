<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionAtender extends Model
{
    use HasFactory;
    protected $table = 'accion_atender'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'accion',
        'tipo',
        'dependencias_responsables',
        'dependencias_coordinadoras',
        'estrategia_id',
    ];

    public function estrategiasAtender()
    {
        return $this->belongsTo(EstrategiasAtender::class, 'estrategia_id');
    }
}


