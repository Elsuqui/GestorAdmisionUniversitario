<?php

use Illuminate\Database\Seeder;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = \App\User::query()->findOrFail(1);

        \Bouncer::assign('Administrador')->to($user);
        \Bouncer::allow($user)->everything();

        \Bouncer::role()->firstOrCreate([
            'name' => 'Operador',
            'title' => 'Usuario operador',
        ]);
    }
}
