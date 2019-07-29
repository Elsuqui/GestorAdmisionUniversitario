<?php


namespace App\Services;


use App\Repository\PersonaRepository;
use Illuminate\Database\Eloquent\Builder;

class PersonaService
{
    protected $personaRepository;
    public function __construct(PersonaRepository $personaRepository)
    {
        $this->personaRepository = $personaRepository;
    }


    public function busquedaPersona($valor){
        return $this->personaRepository->listado(["intereses.carrera.facultad", "intereses.llamadas.usuario_llamada"])
            ->where(function (Builder $query) use ($valor){
                $query->orWhere("cedula", "like", $valor . "%")
                    ->orWhere("nombres", "like", $valor . "%");
            })->get();
    }
}
