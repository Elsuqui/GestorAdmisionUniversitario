<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

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

        $operador = \Bouncer::role()->firstOrCreate([
            'name' => 'Operador',
            'title' => 'Usuario operador',
        ]);

        \Bouncer::allow($operador)->to('ver-/admision');
        \Bouncer::allow($operador)->to('ver-/mail');
        \Bouncer::allow($operador)->to('ver-/llamadas');

    }
}
