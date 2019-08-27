<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Origen extends Model
{
    //
    protected $table = "origenes";
    protected $fillable = [
        "id_tipo_origen",
        "nombre",
        "estado",
        "id_usuario_creador"
    ];
}
