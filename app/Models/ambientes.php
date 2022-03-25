<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ambientes extends Model
{
    protected $table='ambientes';
       
    protected $fillable=[
        'nombre',
        'estado',
    ];

    public $timestamps = false;
    
    public static $rules = [
        'nombre'=>'required|max:5'
    ];
}
