<?php

// app/Models/CalcularAtender.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcularAtender extends Model
{
    use HasFactory;

    protected $table = 'calcular_atender';

    protected $fillable = ['formula', 'variables', 'indicador_atender_id', 'resultado', 'user_id'];

    protected $casts = [
        'variables' => 'json',
    ];
    
    public function indicadorAtender()
    {
        return $this->belongsTo(IndicadorAtender::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
