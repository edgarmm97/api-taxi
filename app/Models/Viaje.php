<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_viaje',
        'id_usuario',
        'id_unidad',
        'id_chofer',
        'total',
        'uid',
        'hora_inicio',
        'hora_fin',
        'latitud_inicio',
        'longitud_inicio',
        'latitud_llegada',
        'longitud_llegada',
    ];

    protected $table = 'aud_solicitud';
    public $timestamps = false;
    public $incrementing = true;
    protected $primariKey = 'id_solicitud';
    
}
