<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self general()
 * @method static self especifica()
 */
class TipoAccionEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'General' => 'General',
            'Especifica' => 'Especifica',
        ];
    }
}
