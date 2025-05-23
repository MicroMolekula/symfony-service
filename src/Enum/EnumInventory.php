<?php

namespace App\Enum;


enum EnumInventory: string
{
    case MINIMAL = 'minimal';
    case HOME = 'home';
    case GYM = 'gym';

    case EMPTY = '';

    public function getLabel(): string
    {
        return match($this) {
            self::MINIMAL => 'Минимум',
            self::HOME => 'Домашний зал',
            self::GYM => 'Тренажерный зал',
            self::EMPTY => '',
        };
    }


}
