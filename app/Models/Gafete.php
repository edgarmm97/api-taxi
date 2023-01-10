<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gafete extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_control_gafete','id_solicitud', 'sm', 'tarjeton'
    ];

    protected $connection = 'mysql2';
    protected $table = 'control_gafete';
    protected $primariKey = 'id_control_gafete';


}
