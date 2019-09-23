<?php

namespace App\Services;

use App\Enums\EstadosInteres;
use App\Interes;
use App\Mail\EmailInformativo;
use App\Mail\EmailMasivoInformacion;
use App\Mail\EmailPersonalizado;
use App\Repository\PersonaRepository;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
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

    public function reportePersonasInteresadas(Request $request){
        /*return $this->personaRepository->listado([
            "contactos.tipoContacto",
            "intereses.carrera.facultad"
        ])->with(["intereses" => function(HasMany $query){
            $query->where("estado_interes", "=", 1);
        }])->get();*/

        $listado = $this->personaRepository->listado([
            "contactos.tipoContacto",
            "intereses.carrera.facultad"
        ])->whereHas("intereses", function ($query){
            $query->where(function ($condicion){
                $condicion->where("estado_interes", "=", EstadosInteres::SIN_NOTIFICAR)
                    ->orWhere("estado_interes", "=", EstadosInteres::NOTIFICADO);
            });
        });

        if($request->has("q")){
            if($request->get("q")){
                $busqueda = $request->get("q");
                $listado = $listado->where(function($condicion) use ($busqueda){
                    $condicion->where("nombres", "like", '%' . $busqueda . '%')
                        ->orWhere("cedula", "like", $busqueda . '%');
                });
            }
        }

        $listado = $listado->whereDate("created_at", ">=", $request->get("fecha_desde"))
            ->whereDate("created_at", "<=", $request->get("fecha_hasta"));

        return $listado->with(["intereses"])->get();
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

    public function enviarMailPersonalizado(array $datos){
        try{
            $interesados = Interes::query()->where("estado_interes", "=", EstadosInteres::INTERESADO)
                ->with(["persona.contactos" => function($query) {
                    $query->where("contactos.id_tipo_contacto", "=", 3);
                }])
                ->get();

            foreach($interesados as $interesado){
                $mail = $interesado["persona"]["contactos"]->first();
                if(!is_null($mail)){
                    $datos["interesado"] = $interesado["persona"]["nombres"];
                    //Mail::to($mail->valor)->queue(new EmailPersonalizado($datos));
                    Mail::to($mail->valor)->queue(new EmailMasivoInformacion($datos));
                }
            }

            return true;
        }catch(\Exception $exception){
            dd($exception->getMessage());
            return false;
        }
    }
}
