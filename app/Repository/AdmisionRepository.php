<?php


namespace App\Repository;


use App\Carrera;
use App\Contacto;
use App\Facultad;
use App\Interes;
use App\Persona;
use App\TipoContacto;
use Illuminate\Support\Facades\Auth;

class AdmisionRepository
{
    public function guardarNuevoInteres(array $datos){
        // Primero creo a la persona
        $persona = Persona::query()->firstOrCreate([
            "nombres" => $datos["nombres"],
            "colegio" => $datos["colegio"]
        ], ["id_usuario_creador" => Auth::id()]);

        // Segundo creo al contacto de telefono convencional

        if($datos["telconv"] != null){
            Contacto::query()->firstOrCreate([
                "id_persona" => $persona->id,
                "valor" => $datos["telconv"],
                "id_tipo_contacto" => TipoContacto::where("descripcion", "=", "TELEFONO CONVENCIONAL")->first()->id,
            ], [
                "id_usuario_creador" => Auth::id()
            ]);
        }

        if($datos["telcel"] != null){
            Contacto::query()->firstOrCreate([
                "id_persona" => $persona->id,
                "valor" => $datos["telcel"],
                "id_tipo_contacto" => TipoContacto::where("descripcion", "=", "TELEFONO CELULAR")->first()->id,
            ], [
                "id_usuario_creador" => Auth::id()
            ]);
        }

        Contacto::query()->firstOrCreate([
            "id_persona" => $persona->id,
            "valor" => $datos["mail"],
            "id_tipo_contacto" => TipoContacto::where("descripcion", "=", "CORREO ELECTRONICO")->first()->id,
        ], [
            "id_usuario_creador" => Auth::id()
        ]);

        // Creo el interes de la persona
        $carrera = Carrera::query()->findOrFail($datos["carrera"]);

        $interes = Interes::query()->firstOrCreate([
            "id_persona" => $persona->id,
            "id_carrera" => $carrera->id,
            "id_origen" => 1,
        ], ["id_usuario_creador" => Auth::id()]);

        return $interes;
    }
}
