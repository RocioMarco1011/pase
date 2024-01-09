<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstrategiasSancionar extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];
    protected $table = 'estrategias_sancionars';

    public function accionSancionar()
    {
        return $this->hasMany(AccionSancionar::class, 'estrategia_id');
    }

}

