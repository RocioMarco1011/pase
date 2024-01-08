<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstrategiasAtender extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];
    protected $table = 'estrategias_atenders';

    public function accionAtender()
    {
        return $this->hasMany(AccionAtender::class, 'estrategia_id');
    }

}
