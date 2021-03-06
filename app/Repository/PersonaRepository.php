<?php

namespace App\Repository;


use App\Interes;
use App\Persona;

class PersonaRepository
{

    protected $persona;

    // Se aplica injeccion de dependencia para el modelo
    public function __construct(Persona $persona)
    {
        $this->persona = $persona;
    }

    public function query(){
        return $this->persona->query();
    }

    /**
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listado(array $relations = []){
        if(count($relations) > 0){
            // Se consulta con relaciones
           return $this->query()
                ->where("estado", "=", true)
                ->with($relations);
        }else{
           return $this->query()
                ->where("estado", "=", true);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function interesados(){
        return Interes::query();
    }

}
