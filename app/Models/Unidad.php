<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_unidad',
        'placa',
        'num_economico',
        'marca',
        'modelo',
        'qr_vehiculo',
        'consesion',
        'created_at',
        'updated_at',
        'is_deleted',
        'deleted_at'
    ];

    protected $hidden = [
        'id_unidad',
        'qr_vehiculo',
        'created_at',
        'updated_at',
        'is_deleted',
        'deleted_at'
    ];

    protected $table = 'cat_unidad';
    public $incrementing = true;
    protected $primariKey = 'id_unidad';

    
}
