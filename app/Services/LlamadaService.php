<?php


namespace App\Services;


use App\Repository\LlamadaRepository;
use Illuminate\Http\Request;

class LlamadaService
{
    protected $llamadaRepository;
    public function __construct(LlamadaRepository $llamadaRepository)
    {
        $this->llamadaRepository = $llamadaRepository;
    }

    public function nueva(Request $request){
        return response()->json($this->llamadaRepository->agregarLlamada($request->all()));
    }
}
