<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaErradicar extends Model
{
    use HasFactory;

    protected $table = 'evidencias_erradicar';

    protected $fillable = ['nombre', 'mensaje', 'archivo', 'accion_erradicar_id'];

    public function accionErradicar()
    {
        return $this->belongsTo(AccionErradicar::class, 'accion_erradicar_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
