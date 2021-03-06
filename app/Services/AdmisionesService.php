<?php


namespace App\Services;


use App\Enums\EstadosInteres;
use App\Interes;
use App\Persona;
use App\Repository\AdmisionRepository;
use Carbon\Carbon;
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

    public function obtenerIntereses(Request $request){
        $intereses = $this->admisionRepository->query();
        if($request->has("estado")){
            if($request->get("estado") != null){
                $estado = $request->get("estado");
                if($estado == 1){
                    // Se filtran los interesados que no han sido contactados
                    $intereses = $intereses->whereDoesntHave("llamadas")
                        ->where("estado_interes", "=", EstadosInteres::NOTIFICADO);
                }else{
                    // Se filtran los interesados a devolver la llamada
                    $intereses = $intereses->whereHas("llamadas", function ($query){
                        $query->where("ultima_llamada", "=", 1)
                            ->where("respuesta", "=", 2);
                    })->where("estado_interes", "=", EstadosInteres::INTERESADO);
                }
            }
        }

        if($request->has("q")){
            if($request->get("q") != null){
                $busqueda = $request->get("q");
                $intereses = $intereses->whereHas("persona", function ($query) use ($busqueda){
                    $query->where(function ($condicion) use ($busqueda){
                        $condicion->where("nombres", "like", '%' . $busqueda . '%')
                            ->orWhere("cedula", "like", $busqueda . '%');
                    });
                });
            }
        }

        $intereses = $intereses->whereDate("created_at", ">=", $request->get("fecha_desde"))
            ->whereDate("created_at", "<=", $request->get("fecha_hasta"));

        return $intereses->with(["persona.intereses", "persona.contactos.tipoContacto", "carrera.facultad", "ultima_llamada"])->get();
    }

    public function reporteEstadosAdmision(){
        $interesados = Interes::query()->where("estado_interes", "=", EstadosInteres::INTERESADO)->get()->count();
        $no_interesados = Interes::query()->where("estado_interes", "=", EstadosInteres::NO_INTERESADO)->get()->count();
        $en_carrera = Interes::query()->where("estado_interes", "=", EstadosInteres::EN_CARRERA)->get()->count();
        return [$interesados, $no_interesados, $en_carrera];
    }

    public function reporteNumeroIngresados(){
        /*$fecha_desde = Carbon::now()->subMonthsNoOverflow()->startOfMonth()->toDateString();
        $fecha_hasta = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();*/
        $fecha_desde = Carbon::now()->startOfMonth()->toDateString();
        $fecha_hasta = Carbon::now()->endOfMonth()->toDateString();
        return Persona::query()->where(function ($query) use($fecha_desde, $fecha_hasta){
           $query->whereDate("created_at", ">=", $fecha_desde)
               ->whereDate("created_at", "<=", $fecha_hasta);
        })->get()->count();
    }
}
