<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionTransporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_sesion_transporte',
        'id_chofer',
        'id_unidad',
        'login_at',
        'is_servicio',
        'is_viaje',
        'is_solicitud',
    ];

    protected $table = 'aud_sesion_transporte';
    public $timestamps = false;
    public $incrementing = true;
    protected $primariKey = 'id_sesion_transporte';
}
