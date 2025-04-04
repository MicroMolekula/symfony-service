<?php

namespace App\Enum;


enum EnumInventory: string
{
    case DUMBBELLS = 'dumbbells';
    case YOGA_MAT = 'yoga_mat';
    case JUMP_ROPE = 'jump_rope';
    case RESISTANCE_BANDS = 'resistance_bands';
    case KETTLEBELL = 'kettlebell';
    case PUSH_UP_BARS = 'push_up_bars';
    case AB_WHEEL = 'ab_wheel';
    case FOAM_ROLLER = 'foam_roller';
    case MEDICINE_BALL = 'medicine_ball';
    case PULL_UP_BAR = 'pull_up_bar';

    public function getLabel(): string
    {
        return match($this) {
            self::DUMBBELLS => 'Гантели',
            self::YOGA_MAT => 'Коврик для йоги',
            self::JUMP_ROPE => 'Скакалка',
            self::RESISTANCE_BANDS => 'Эспандеры',
            self::KETTLEBELL => 'Гиря',
            self::PUSH_UP_BARS => 'Брусья для отжиманий',
            self::AB_WHEEL => 'Ролик для пресса',
            self::FOAM_ROLLER => 'Массажный ролик',
            self::MEDICINE_BALL => 'Медицинбол',
            self::PULL_UP_BAR => 'Турник',
        };
    }


}
