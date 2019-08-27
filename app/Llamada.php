<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Llamada extends Model
{
    //
    protected $table = "llamadas";
    protected $fillable = [
        "id_interesado",
        "id_usuario_llamada",
        "orden",
        "inicio_llamada",
        "fin_llamada",
        "fecha_llamada",
        'observacion',
        "respuesta",
        "utlima_llamada",
        "id_usuario_creador"
    ];

    public function usuario_llamada(){
        return $this->belongsTo(User::class, "id_usuario_llamada");
    }

    public function interesado(){
        return $this->belongsTo(Interes::class, "id_interesado");
    }
}
