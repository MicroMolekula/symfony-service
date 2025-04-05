<?php

namespace App\Enum;

enum EnumGender: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    case EMPTY = '';


    // Опционально: метод для получения читаемого названия
    public function label(): string
    {
        return match($this) {
            self::MALE => 'Мужской',
            self::FEMALE => 'Женский',
            self::EMPTY => '',
        };
    }
}