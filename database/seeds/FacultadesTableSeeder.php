<?php

use Illuminate\Database\Seeder;

class FacultadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Facultad::create([
            "nombre" => "INGENIERIA",
            "id_usuario_creador" => 1
        ]);
    }
}
