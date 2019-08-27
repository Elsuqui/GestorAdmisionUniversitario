<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContacto extends Model
{
    //
    protected $table = "tipo_contactos";
    protected $fillable = [
        "descripcion",
        "id_usuario_llamada",
        "estado",
        "id_usuario_creador"
    ];
}
