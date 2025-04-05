<?php

namespace App\Enum;


enum EnumTarget: string
{
    case STRENGTH = 'strength';
    case FIT = 'fit';
    case THICK = 'thick';
    case EMPTY = '';


    public function getLabel(): string
    {
        return match($this) {
            self::STRENGTH => 'Стать сильнее',
            self::FIT => 'Поддержать форму',
            self::THICK => 'Стать стройнее',
        };
    }
}
