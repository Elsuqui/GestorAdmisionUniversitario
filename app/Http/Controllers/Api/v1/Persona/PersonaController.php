<?php

namespace App\Http\Controllers\Api\v1\Persona;

use App\Services\AdmisionesService;
use App\Services\PersonaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonaController extends Controller
{
    //
    protected $personaService, $admisionService;
    public function __construct(PersonaService $personaService, AdmisionesService $admisionService)
    {
        $this->personaService = $personaService;
        $this->admisionService = $admisionService;
    }

    public function busqueda(Request $request){
        if($request->has("valor")){
            $valor = $request->get("valor");
            if(strlen($valor) > 0){
                return response()->json($this->personaService->busquedaPersona($valor));
            }
        }

        return response()->json([]);
    }

    public function intereses(Request $request){
        return response()->json($this->personaService->llamadasInteresados($request));
    }

    public function listadoInteresados(Request $request){
        return response()->json($this->admisionService->obtenerIntereses($request));
    }
}
