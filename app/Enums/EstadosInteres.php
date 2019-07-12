<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EstadosInteres extends Enum
{
    const SIN_NOTIFICAR = 1;
    const NOTIFICADO = 2;
    const ACEPTADO = 3;
    const RECHAZADO = 4;
}
