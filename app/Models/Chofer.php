<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'id_chofer',
        'nombre',
        'ap_paterno',
        'ap_materno',
        'tarjeton',
        'vencimiento_tarjeton',
        'vencimiento_licencia',
        'qr_tarjeton',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_deleted',
        'foto',
        'correo_electronico',
        'num_telefono'
    ];

    protected $hidden = [
        'id_chofer',
        'vencimiento_tarjeton',
        'vencimiento_licencia',
        'qr_tarjeton',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_deleted',
    ];

    protected $table = 'cat_chofer';
    public $incrementing = true;
    protected $primariKey = 'id_chofer';
}
