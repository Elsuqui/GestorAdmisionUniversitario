<?php

namespace App\Http\Controllers\Api\v1\Persona;

use App\Services\PersonaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonaController extends Controller
{
    //
    protected $personaService;
    public function __construct(PersonaService $personaService)
    {
        $this->personaService = $personaService;
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
}
