<?php

namespace App\Http\Controllers\Api\v1\Archivos;

use App\Imports\InteresadosImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ArchivosController extends Controller
{
    //
    public function subirExcelBase(Request $request){
        try{
            Excel::import(new InteresadosImport(Auth::id()), $request->file("file"));
            return [
                "estado" => true,
                "mensaje" => "Se procesó correctamnete el archivo"
            ];
        }catch(\ErrorException $e){
            return [
                "estado" => false,
                "mensaje" => "No se pudo procesar el archivo del excel",
                "error" => $e->getMessage()
            ];
        }
    }
}
