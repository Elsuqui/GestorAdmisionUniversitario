<?php


namespace App\Repository;


use App\Origen;
use App\User;
use Silber\Bouncer\Database\Role;

class UsuarioRepository
{
    protected $usuario, $origen;

    public function __construct(User $usuario, Origen $origen)
    {
        $this->usuario = $usuario;
        $this->origen = $origen;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->usuario->query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function origen_query()
    {
        return $this->origen->query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function roles_query()
    {
        return Role::query();
    }

    public function editarUsuario(array $datos, $id)
    {
        $usuario = $this->query()->findOrFail($id);
        return $usuario->update($datos);
    }

    /**
     * @param array $datos
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function crearUsuario(array $datos)
    {
        $datos["password"] = 1234;
        return $this->query()->create([
            "username" => $datos["username"],
            "email" => $datos["email"],
            "name" => $datos["name"],
            "password" => bcrypt($datos["password"]),
            "id_origen" => $datos["id_origen"]
        ]);
    }
}
