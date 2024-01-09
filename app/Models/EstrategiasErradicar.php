<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstrategiasErradicar extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];
    protected $table = 'estrategias_erradicars';

    public function accionErradicar()
    {
        return $this->hasMany(AccionErradicar::class, 'estrategia_id');
    }

}

