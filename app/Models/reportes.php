<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reportes extends Model
{
    protected $table = 'reportes';

    protected $fillable=[
        'instructor',
        'descripcionGeneral',
        'estado',
    ];

    public static $rules = [
        'instructor'=>'required',
        'descripcionGeneral'=>'required'
    ];
}
