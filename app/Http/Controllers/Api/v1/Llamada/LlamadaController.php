<?php

namespace App\Http\Controllers\Api\v1\Llamada;

use App\Services\LlamadaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LlamadaController extends Controller
{
    //
    protected $llamadaService;
    public function __construct(LlamadaService $llamadaService)
    {
        $this->llamadaService = $llamadaService;
    }

    public function nueva(Request $request){
        return $this->llamadaService->nueva($request);
    }

    public function reporteLlamadas(Request $request){
        return $this->llamadaService->reporteLlamadas($request);
    }
}
