<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'nombre',
        'ap_paterno',
        'ap_materno',
        'correo_electronico',
        'contrasenia',
        'is_deleted',
        'is_activo',
        'login_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'num_telefono',
        'fecha_nacimiento',
        'sexo'
    ];

    protected $table = 'cat_usuario';
    public $incrementing = true;
    protected $primariKey = 'id_usuario';
}
