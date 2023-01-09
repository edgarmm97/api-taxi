<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_solicitud',
        'id_usuario',
        'id_unidad',
        'hora_solicitud',
        'hora_llegada',
        'is_activo',
        'latitud',
        'longitud',
    ];

    protected $table = 'aud_solicitud';
    public $timestamps = false;
    public $incrementing = true;
    protected $primariKey = 'id_solicitud';

    
}
