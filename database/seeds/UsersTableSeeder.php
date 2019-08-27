<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Origen;
use \App\TipoOrigen;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creación de usuario inicial de BD
        $user = User::create([
            "username" => "usuario.admin",
            "name" => "Administrador",
            "email" => "admin@mail.com",
            "password" => bcrypt("tesis.rios")
        ]);

        $tipo_origen = TipoOrigen::create([
            "descripcion" => "Isla informativa",
            "estado" => true,
            "id_usuario_creador" => $user->id
        ]);

        $origen = Origen::create([
            "id_tipo_origen" => $tipo_origen->id,
            "nombre" => "San Marino",
            "estado" => true,
            "id_usuario_creador" => $user->id
        ]);

        $user->id_origen = $origen->id;
        $user->saveOrFail();

        \Bouncer::assign('Administrador')->to($user);
        \Bouncer::allow($user)->everything();

    }
}
