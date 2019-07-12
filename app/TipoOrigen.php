<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoOrigen extends Model
{
    //
    protected $table = "tipo_origenes";
    protected $fillable = [
        "descripcion",
        "estado",
        "id_usuario_creador"
    ];
}
