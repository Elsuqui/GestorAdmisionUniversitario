<?php


namespace App\Repository;


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
            if(!is_null($llamada_anterior) > 0){
                $llamada_anterior->ultima_llamada = false;
                $orden = $llamada_anterior->orden + 1;
                $llamada_anterior->saveOrFail();
            }

            $this->query()->create([
                "id_interesado" => $datos["id_interesado"],
                "id_usuario_llamada" => Auth::id(),
                "orden" => $orden,
                "fecha_llamada" => Carbon::now()->toDateString(),
                "respuesta" => $datos["respuesta"],
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
