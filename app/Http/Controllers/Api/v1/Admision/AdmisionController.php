<?php

namespace App\Http\Controllers\Api\v1\Admision;

use App\Services\AdmisionesService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmisionController extends Controller
{
    protected $admisionService;
    public function __construct(AdmisionesService $admisionesService)
    {
        $this->admisionService = $admisionesService;
    }

    //
    public function store(Request $request){
        try{
            return $this->admisionService->guardarNuevoInteres($request);
        }catch(\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function cambiarEstadoInteres(Request $request){
        return response()->json($this->admisionService->cambiarEstadoInteres($request));
    }

    public function reporteEstadosAdmision(){
        return response()->json($this->admisionService->reporteEstadosAdmision());
    }

    public function reporteNumeroIngresados(){
        return response()->json($this->admisionService->reporteNumeroIngresados());
    }
}
