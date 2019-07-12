@component('mail::message')
Universidad Católica Santiago de Guayaquil <br/>

![Some option text][logo]
[logo]: {{asset("imagenes/ucsg_logo.png")}} "UCSG"

Estimado <strong>{{ $data["interesado"] }}</strong><br/>

Basado en su interés estudiantil universitario en la carrera de : <strong>{{ $data["carrera"] }}</strong>

La facultad de <strong>{{ $data["facultad"] }}</strong>
tiene el agrado de comunicarse con usted para que pueda conocer más acerca
de la carrera, pulsando el siguiente link:

@component('mail::button', ['url' => route("ingresar")])
Ver información
@endcomponent

Saludos Cordiales,<br>
UCSG
@endcomponent
