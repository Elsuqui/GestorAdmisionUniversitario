<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EstadosInteres extends Enum
{
    const SIN_NOTIFICAR = 1;
    const NOTIFICADO = 2;
    const INTERESADO = 3;
    const NO_INTERESADO = 4;
    const EN_CARRERA = 5;
}
