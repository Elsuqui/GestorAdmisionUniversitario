<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    protected $table = "personas";
    protected $fillable = [
        "cedula",
        "nombres",
        "colegio",
        "estado",
        "id_usuario_creador"
    ];

    public function contactos(){
        return $this->hasMany(Contacto::class, "id_persona");
    }

    public function intereses(){
        return $this->hasMany(Interes::class, "id_persona");
    }
}
