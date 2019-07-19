<?php

namespace App\Services;

use App\Enums\EstadosInteres;
use App\Interes;
use App\Mail\EmailInformativo;
use App\Repository\PersonaRepository;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class MailService
{
    protected $personaRepository;
    // Se inyectan los repositorios necesarios
    public function __construct(PersonaRepository $personaRepository)
    {
        $this->personaRepository = $personaRepository;
    }

    public function reportePersonasInteresadas(){
        /*return $this->personaRepository->listado([
            "contactos.tipoContacto",
            "intereses.carrera.facultad"
        ])->with(["intereses" => function(HasMany $query){
            $query->where("estado_interes", "=", 1);
        }])->get();*/
        return $this->personaRepository->listado([
            "contactos.tipoContacto",
            "intereses.carrera.facultad"
        ])->with(["intereses"])->get();
    }

    public function enviarEmailInformativo(Collection $interes){
        $contactos = collect($interes["contactos"])->filter(function ($contacto){
            return $contacto["tipo_contacto"]["id"] == 3;
        })->values();

        $contactos->map(function ($contacto) use ($interes){
            //Mail::to($contacto["valor"])->queue(new EmailInformativo());
            foreach ($interes["intereses"] as $interes_obj) {
                try{
                    Mail::to($contacto["valor"])->queue(new EmailInformativo([
                        "interesado" => $interes["nombres"],
                        "carrera" => $interes_obj["carrera"]["nombre"],
                        "facultad" => $interes_obj["carrera"]["facultad"]["nombre"]
                    ]));
                    $interes_temp = Interes::query()->findOrFail($interes_obj["id"]);
                    $interes_temp["estado_interes"] = EstadosInteres::NOTIFICADO;
                    $interes_temp->save();

                }catch(Exception $exception){
                    return dd($exception->getMessage());
                }
            }
        });
    }
}
