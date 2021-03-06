<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(FacultadesTableSeeder::class);
        $this->call(CarrerasTableSeeder::class);
        $this->call(TipoContactosTableSeeder::class);
        $this->call(RolesPermissionSeeder::class);
    }
}
