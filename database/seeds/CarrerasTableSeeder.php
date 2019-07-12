<?php

use Illuminate\Database\Seeder;

class CarrerasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Carrera::create([
            "id_facultad" => \App\Facultad::where("nombre", "=", "INGENIERIA")->first()->id,
            "nombre" => "Ciencias de la computación",
            "id_usuario_creador" => 1
        ]);
    }
}
