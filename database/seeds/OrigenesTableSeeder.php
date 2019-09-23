<?php

use App\Origen;
use App\TipoOrigen;
use Illuminate\Database\Seeder;

class OrigenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $centro_comercial = TipoOrigen::firstOrCreate([
            "descripcion" => "Centro Comercial",
            "estado" => 1,
            "id_usuario_creador" => 1
        ]);

        $universidad = TipoOrigen::firstOrCreate([
            "descripcion" => "Universidad",
            "estado" => 1,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $centro_comercial->id,
            "nombre" => "Mall del Sur",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $centro_comercial->id,
            "nombre" => "Riocentro Norte",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $centro_comercial->id,
            "nombre" => "Riocentro Norte",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $centro_comercial->id,
            "nombre" => "Riocentro Ceibos",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $universidad->id,
            "nombre" => "Coordinación de Admisión",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $universidad->id,
            "nombre" => "Secretaría de la facultad",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $universidad->id,
            "nombre" => "Centro de formación",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);

        Origen::create([
            "id_tipo_origen" => $universidad->id,
            "nombre" => "Call Center",
            "estado" => true,
            "id_usuario_creador" => 1
        ]);
    }
}
