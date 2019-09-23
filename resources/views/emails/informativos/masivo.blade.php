@component('mail::message')
# Introduction
Universidad Católica Santiago de Guayaquil <br/>

![Some option text][logo]
[logo]: {{asset("imagenes/ucsg_logo.png")}}

Estimado <strong>{{ $data["interesado"] }}</strong><br/>

<hr/>

{!!  $data["cuerpo"] !!}

<hr/>

{!! $data["pie"] !!}

Saludos Cordiales,<br>
UCSG
@endcomponent
