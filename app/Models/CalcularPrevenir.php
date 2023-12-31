<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CalcularPrevenirController;

class CalcularPrevenir extends Model
{
    use HasFactory;
    protected $table = 'calcular_prevenir';

    protected $fillable = ['formula', 'indicador_prevenir_id', 'resultado', 'user_id'];

    public function indicadorPrevenir()
    {
        return $this->belongsTo(IndicadorPrevenir::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}