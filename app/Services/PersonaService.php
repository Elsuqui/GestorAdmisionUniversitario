<?php


namespace App\Services;


use App\Repository\LlamadaRepository;
use App\Repository\PersonaRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaService
{
    protected $personaRepository, $llamadasRepository;
    public function __construct(PersonaRepository $personaRepository, LlamadaRepository $llamadasRepository)
    {
        $this->personaRepository = $personaRepository;
        $this->llamadasRepository = $llamadasRepository;
    }


    public function busquedaPersona($valor){
        return $this->personaRepository->listado(["intereses.carrera.facultad", "intereses.llamadas.usuario_llamada"])
            ->where(function (Builder $query) use ($valor){
                $query->orWhere("cedula", "like", $valor . "%")
                    ->orWhere("nombres", "like", $valor . "%");
            })->get();
    }

    public function llamadasInteresados(Request $request){
        if($request->has("estado")){
            $llamadas = $this->llamadasRepository->query()->where("respuesta", "=", $request->get("estado"))
                ->where("ultima_llamada", "=", 1);
            if($request->has("fecha_desde") && $request->has("fecha_hasta")){
                $llamadas = $llamadas->whereDate("created_at", ">=", $request->get("fecha_desde"))
                    ->whereDate("created_at", "<=", $request->get("fecha_hasta"));
            }

            $llamadas = $llamadas->with(["interesado.persona.contactos.tipoContacto", "interesado.carrera.facultad", "usuario_llamada"])->get();
            return $llamadas;
        }

        return [];
    }
}
