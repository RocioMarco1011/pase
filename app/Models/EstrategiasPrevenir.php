<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstrategiasPrevenir extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];
    protected $table = 'estrategias_prevenirs';

}
