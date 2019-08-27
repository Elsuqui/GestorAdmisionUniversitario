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

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listadoLlamadas(){
        return $this->llamadaRepository->query();
    }

    public function reporteLlamadas(Request $request){
        $llamadas = $this->listadoLlamadas();
        if($request->has("tipo_consulta")){
            if($request->has("q")){
                if($request->get("q") !== null){
                    if($request->get("tipo_consulta") === "1"){
                        //El reporte es por estudiante
                        $llamadas = $llamadas->whereHas("interesado.persona", function ($query) use ($request){
                            $query->where("nombres", "like", '%' . $request->get("q") . '%')
                                ->orWhere("cedula", "like", $request->get("q") . '%');
                        });
                    }else if($request->get("tipo_consulta") === "2"){
                        // El reporte es por operador
                        $llamadas = $llamadas->whereHas("usuario_llamada", function ($query) use ($request){
                            $query->where("name", "like", '%' . $request->get("q") . '%');
                        });
                    }
                }
            }else{
                if($request->has("fecha_desde") && $request->has("fecha_hasta")){
                    $llamadas = $llamadas->whereDate("created_at", ">=", $request->get("fecha_desde"))
                        ->whereDate("created_at", "<=", $request->get("fecha_hasta"));
                }
            }
        }

        $llamadas = $llamadas
            ->with(["interesado.persona.contactos.tipoContacto", "interesado.carrera.facultad", "usuario_llamada"])
            ->get()
            ->sortByDesc("interesado.persona.nombres")
            ->sortByDesc("interesado.usuario_llamada.name")
            ->values();

        return $llamadas;
    }
}
