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
}
