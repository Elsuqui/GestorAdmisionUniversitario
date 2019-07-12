<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    //
    protected $table = "contactos";
    protected $fillable = [
        "id_persona",
        "id_tipo_contacto",
        "valor",
        "estado",
        "id_usuario_creador"
    ];

    public function tipoContacto(){
        return $this->belongsTo(TipoContacto::class, "id_tipo_contacto");
    }
}
