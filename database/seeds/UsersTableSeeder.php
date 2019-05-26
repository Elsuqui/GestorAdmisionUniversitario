<?php

use Illuminate\Database\Seeder;
use \App\User;

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
        User::create([
            "username" => "usuario.admin",
            "name" => "Administrador",
            "email" => "admin@mail.com",
            "password" => bcrypt("tesis.rios")
        ]);
    }
}
