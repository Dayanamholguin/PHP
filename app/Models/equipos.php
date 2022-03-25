<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipos extends Model
{
    protected $table = 'equipos';

    protected $fillable=[
        'modelo',
        'consec',
        'descc',
        'descripcionActual',
        'tipoMod',
        'ambiente',
        'instructorAsignado',
        'estado',
    ];

    public $timestamps = false;

    public static $rules = [
        'modelo'=>'required|max:20',
        'consec'=>'required|max:20',
        'descc'=>'required|max:20',
        'descripcionActual'=>'required|max:150',
        'tipoMod'=>'required|max:20',
        'ambiente'=>'required',
        'instructorAsignado'=>'required'
    ];
}
