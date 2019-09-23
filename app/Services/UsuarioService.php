<?php


namespace App\Services;


use App\Repository\UsuarioRepository;
use Illuminate\Http\Request;

class UsuarioService
{
    protected $usuarioRepository;
    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listado_usuarios(){
        return $this->usuarioRepository->query()->with(["origen", "roles"]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listado_origenes(){
        return $this->usuarioRepository->origen_query()->where("estado", "=", 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function obtenerRoles(){
        return $this->usuarioRepository->roles_query();
    }

    public function editarUsuario(Request $request, $id){
        return $this->usuarioRepository->editarUsuario($request->all(), $id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function crearUsuario(Request $request){
        return $this->usuarioRepository->crearUsuario($request->all());
    }

    public function asignarRol(Request $request){
        return $this->usuarioRepository->query()->findOrFail($request->get("usuario"))->assign($request->get("rol"));
    }

    public function removerRol(Request $request){
        return $this->usuarioRepository->query()->findOrFail($request->get("usuario"))->retract($request->get("rol"));
    }
}
