<?php

namespace App\Http\Controllers\Api\v1\Usuario;

use App\Services\UsuarioService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    //
    protected $usuarioService;
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index(Request $request){
        return $this->usuarioService->listado_usuarios()->get();
    }

    public function obtenerRoles(){
        return $this->usuarioService->obtenerRoles()->get();
    }

    public function update(Request $request, $id){
        return response()->json($this->usuarioService->editarUsuario($request, $id));
    }

    public function store(Request $request){
        $this->validate($request, [
            "email" => "unique:users"
        ], [
            "email.unique" => "El email ya se encuentra registrado!"
        ]);

        return $this->usuarioService->crearUsuario($request);
    }

    public function asignarRol(Request $request){
        return $this->usuarioService->asignarRol($request);
    }

    public function removerRol(Request $request){
        return $this->usuarioService->removerRol($request);
    }
}
