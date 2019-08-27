<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    //
    protected $table = "carreras";
    protected $fillable = [
        "id_facultad",
        "nombre",
        "estado",
        "id_usuario_creador"
    ];

    public function facultad(){
        return $this->belongsTo(Facultad::class, "id_facultad");
    }
}
