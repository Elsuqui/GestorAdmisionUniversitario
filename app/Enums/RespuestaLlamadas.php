<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RespuestaLlamadas extends Enum
{
    const NO_LLAMAR = 1;
    const DEVOLVER_LLAMADA = 2;
    const LLAMAR_DESPUES = 3;
}
