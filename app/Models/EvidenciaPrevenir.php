<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaPrevenir extends Model
{
    use HasFactory;

    protected $table = 'evidencias_prevenir';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'mensaje',
        'accion_prevenir_id',
    ];

    public function accionPrevenir()
    {
        return $this->belongsTo(AccionPrevenir::class, 'accion_prevenir_id');
    }
}

