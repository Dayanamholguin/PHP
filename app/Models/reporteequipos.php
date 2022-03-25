<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporteequipos extends Model
{
    protected $table = 'reporteequipos';

    protected $fillable = [
        'reporte', 
        'equipo', 
        'descripcion',
        'estado',
    ];
}
