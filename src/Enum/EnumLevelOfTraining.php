<?php

namespace App\Enum;


enum EnumLevelOfTraining: string
{
    case BEGINNER = 'beginner';
    case AMATEUR = 'amateur';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';
    case PROFESSIONAL = 'professional';

    public function getLabel(): string
    {
        return match($this) {
            self::BEGINNER => 'Новичок',
            self::AMATEUR => 'Любитель',
            self::INTERMEDIATE => 'Средний уровень',
            self::ADVANCED => 'Продвинутый',
            self::PROFESSIONAL => 'Профессионал',
        };
    }
}
