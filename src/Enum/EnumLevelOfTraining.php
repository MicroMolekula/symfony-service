<?php

namespace App\Enum;


enum EnumLevelOfTraining: string
{
    case NEVER_TRAINED = 'never_trained';
    case WALKED = 'walked';
    case MAINTAINED = 'maintained';
    case ACTIVE = 'active';

    public function getLabel(): string
    {
        return match($this) {
            self::NEVER_TRAINED => 'Ничего не делал',
            self::WALKED => 'Ходил пешком',
            self::MAINTAINED => 'Поддерживал форму',
            self::ACTIVE => 'Активно упражнялся',

        };
    }
}
