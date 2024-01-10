<?php

// app/Models/CalcularSancionar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcularSancionar extends Model
{
    use HasFactory;

    protected $table = 'calcular_sancionar';

    protected $fillable = ['formula', 'variables', 'indicador_sancionar_id', 'resultado', 'user_id'];

    protected $casts = [
        'variables' => 'json',
    ];
    
    public function indicadorSancionar()
    {
        return $this->belongsTo(IndicadorSancionar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
