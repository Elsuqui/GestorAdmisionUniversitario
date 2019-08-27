<?php


namespace App\Repository;


use App\Enums\EstadosInteres;
use App\Enums\RespuestaLlamadas;
use App\Interes;
use App\Llamada;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LlamadaRepository
{
    protected $llamada;

    public function __construct(Llamada $llamada)
    {
        $this->llamada = $llamada;
    }

    public function query()
    {
        return $this->llamada->query();
    }

    public function agregarLlamada(array $datos)
    {
        //Se busca si existe una llamada del interesado
        try{
            DB::beginTransaction();
            $llamada_anterior = $this->query()->where("id_interesado", "=", $datos["id_interesado"])->latest()->first();
            $orden = 1;
            $estado_llamada = RespuestaLlamadas::NO_LLAMAR;

            if(!is_null($llamada_anterior) > 0){
                $llamada_anterior->ultima_llamada = false;
                $orden = $llamada_anterior->orden + 1;
                $llamada_anterior->saveOrFail();
            }

            // Verifico la respuesta de acuerdo con el estado de interes de la persona
            if($datos["respuesta"] == 3){
                $interesado = Interes::query()->findOrFail($datos["id_interesado"]);
                $interesado->estado_interes = EstadosInteres::INTERESADO;
                $interesado->saveOrFail();
                // Esta interesado entonces se debe preguntar si hay que volver a llamar
                if($datos["devolver_llamada"] == true){
                    // El interesado esta de acuerdo pero necesita que le devuelvan la llamada
                    $estado_llamada = RespuestaLlamadas::DEVOLVER_LLAMADA;
                }
            }else{
                $interesado = Interes::query()->findOrFail($datos["id_interesado"]);
                $interesado->estado_interes = EstadosInteres::getValue(EstadosInteres::getKey($datos["respuesta"]));
                $interesado->saveOrFail();
            }


            $this->query()->create([
                "id_interesado" => $datos["id_interesado"],
                "id_usuario_llamada" => Auth::id(),
                "orden" => $orden,
                "fecha_llamada" => Carbon::now()->toDateString(),
                "respuesta" => $estado_llamada,
                "observacion" => $datos["observacion"],
                "ultima_llamada" => true,
                "id_usuario_creador" => Auth::id()
            ]);


            DB::commit();
            return true;
        }catch (\Exception $exception){
            DB::rollback();
            dd($exception->getMessage());
            return false;
        }
    }
}
