@component('mail::message')
Universidad Católica Santiago de Guayaquil <br>

![Some option text][logo]
[logo]: {!! asset("imagenes/ucsg_logo.png") !!}

Estimado {!! $data["interesado"] . "\n" !!}

{!! "-----------------------------------------------------\n" !!}

{!!  $data["cuerpo"] !!}


{{--@component('mail::button', ['url' => "https://www.ucsg.edu.ec/"])
    Ver información
@endcomponent--}}

{!! "-----------------------------------------------------\n" !!}

{!! $data["pie"] !!}


Saludos Cordiales,<br>
UCSG
@endcomponent

