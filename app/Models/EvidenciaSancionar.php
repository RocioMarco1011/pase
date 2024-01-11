<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaSancionar extends Model
{
    use HasFactory;

    protected $table = 'evidencias_sancionar';

    protected $fillable = ['nombre', 'mensaje', 'archivo', 'accion_sancionar_id'];

    public function accionSancionar()
    {
        return $this->belongsTo(AccionSancionar::class, 'accion_sancionar_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
