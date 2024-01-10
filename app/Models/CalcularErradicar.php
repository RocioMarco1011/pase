<?php

// app/Models/CalcularErradicar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcularErradicar extends Model
{
    use HasFactory;

    protected $table = 'calcular_erradicar';

    protected $fillable = ['formula', 'variables', 'indicador_erradicar_id', 'resultado', 'user_id'];

    protected $casts = [
        'variables' => 'json',
    ];
    
    public function indicadorErradicar()
    {
        return $this->belongsTo(IndicadorErradicar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
