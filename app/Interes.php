<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interes extends Model
{
    //
    protected $table = "intereses";
    protected $fillable = [
        "id_persona",
        "id_carrera",
        "id_origen",
        "id_usuario_creador"
    ];

    public function carrera(){
        return $this->belongsTo(Carrera::class, "id_carrera");
    }

    public function origen(){
        return $this->belongsTo(Origen::class, "id_origen");
    }

    public function llamadas(){
        return $this->hasMany(Llamada::class, "id_interesado");
    }

    public function persona(){
        return $this->belongsTo(Persona::class, "id_persona");
    }

    public function ultima_llamada(){
        return $this->hasOne(Llamada::class, "id_interesado")->latest();
    }
}
