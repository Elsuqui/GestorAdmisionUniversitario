<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    //
    protected $table = "facultades";
    protected $fillable = [
        "nombre",
        "estado",
        "id_usuario_creador"
    ];
}
