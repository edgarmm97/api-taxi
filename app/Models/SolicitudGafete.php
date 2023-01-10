<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudGafete extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'solicitud';
    protected $primariKey = 'id_solicitud';
}
