<?php

namespace App\Enum;


enum EnumLevelOfTraining: string
{
    case NOTHING = 'nothing';
    case WALK = 'walk';
    case FIT = 'fit';
    case ACTIVE = 'active';

    case EMPTY = '';

    public function getLabel(): string
    {
        return match($this) {
            self::NOTHING => 'Ничего не делал',
            self::WALK => 'Ходил пешком',
            self::FIT => 'Поддерживал форму',
            self::ACTIVE => 'Активно упражнялся',
            self::EMPTY => '',
        };
    }
}
