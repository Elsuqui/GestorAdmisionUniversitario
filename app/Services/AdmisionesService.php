<?php


namespace App\Services;


use App\Repository\AdmisionRepository;
use Illuminate\Http\Request;

class AdmisionesService
{
    protected $admisionRepository;
    public function __construct(AdmisionRepository $admisionRepository)
    {
        $this->admisionRepository = $admisionRepository;
    }

    public function guardarNuevoInteres(Request $request){
        $interes = null;
        try{
            $interes = $this->admisionRepository->guardarNuevoInteres($request->all());
        }catch(\Exception $exception){
            dd($exception->getMessage());
        }

        return $interes;
    }

    public function cambiarEstadoInteres(Request $request){
        return $this->admisionRepository->cambiarEstadoInteres($request->all());
    }
}
