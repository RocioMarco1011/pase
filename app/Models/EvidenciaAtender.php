<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaAtender extends Model
{
    use HasFactory;

    protected $table = 'evidencias_atender';

    protected $fillable = ['nombre', 'mensaje', 'archivo', 'accion_atender_id'];

    public function accionAtender()
    {
        return $this->belongsTo(AccionAtender::class, 'accion_atender_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
