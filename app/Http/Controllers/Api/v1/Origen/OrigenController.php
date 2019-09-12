<?php


namespace App\Http\Controllers\Api\v1\Origen;


use App\Services\UsuarioService;

class OrigenController
{
    protected $usuarioService;
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index(){
        return $this->usuarioService->listado_origenes()->get();
    }
}
