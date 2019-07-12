<?php

use Illuminate\Database\Seeder;

class TipoContactosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\TipoContacto::create([
           "descripcion" => "TELEFONO CONVENCIONAL",
           "id_usuario_creador" => 1
        ]);

        \App\TipoContacto::create([
            "descripcion" => "TELEFONO CELULAR",
            "id_usuario_creador" => 1
        ]);

        \App\TipoContacto::create([
            "descripcion" => "CORREO ELECTRONICO",
            "id_usuario_creador" => 1
        ]);
    }
}
