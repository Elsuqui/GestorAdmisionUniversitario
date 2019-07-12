<?php

namespace App\Imports;

use App\Carrera;
use App\Contacto;
use App\Facultad;
use App\Interes;
use App\Origen;
use App\Persona;
use App\TipoContacto;
use App\TipoOrigen;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class InteresadosImport implements ToCollection, WithHeadingRow
{
    public $usuario = 0;

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if($row->filter()->isNotEmpty()){
                // Primero creo a la persona
                $persona = Persona::query()->firstOrCreate([
                    "nombres" => $row["nombres"],
                    "colegio" => $row["unidad_educativa"]
                ], ["id_usuario_creador" => $this->usuario]);

                // Segundo creo al contacto de telefono convencional
                Contacto::query()->firstOrCreate([
                    "id_persona" => $persona->id,
                    "valor" => $row["telefono_convencional"],
                    "id_tipo_contacto" => TipoContacto::where("descripcion", "=", "TELEFONO CONVENCIONAL")->first()->id,
                ], [
                    "id_usuario_creador" => $this->usuario
                ]);

                Contacto::query()->firstOrCreate([
                    "id_persona" => $persona->id,
                    "valor" => $row["telefono_celular"],
                    "id_tipo_contacto" => TipoContacto::where("descripcion", "=", "TELEFONO CELULAR")->first()->id,
                ], [
                    "id_usuario_creador" => $this->usuario
                ]);

                Contacto::query()->firstOrCreate([
                    "id_persona" => $persona->id,
                    "valor" => $row["correo_electronico"],
                    "id_tipo_contacto" => TipoContacto::where("descripcion", "=", "CORREO ELECTRONICO")->first()->id,
                ], [
                    "id_usuario_creador" => $this->usuario
                ]);

                // Creo el interes de la persona
                $facultad = Facultad::query()->firstOrCreate(
                    ["nombre" => $row["facultad"]],
                    ["id_usuario_creador" => $this->usuario]
                );

                $carrera = Carrera::query()->firstOrCreate(
                    ["id_facultad" => $facultad->id, "nombre" => $row["carrera"]],
                    ["id_usuario_creador" => $this->usuario]
                );

                $tipo_origen = TipoOrigen::query()->firstOrCreate(
                    ["descripcion" => $row["tipo_origen"]],
                    ["id_usuario_creador" => $this->usuario]
                );

                $origen = Origen::query()->firstOrCreate(
                    ["nombre" => $row["origen"], "id_tipo_origen" => $tipo_origen->id],
                    ["id_usuario_creador" => $this->usuario]
                );

                Interes::query()->firstOrCreate([
                    "id_persona" => $persona->id,
                    "id_carrera" => $carrera->id,
                    "id_origen" => $origen->id
                ], ["id_usuario_creador" => $this->usuario]);
            }
        }
    }
}
