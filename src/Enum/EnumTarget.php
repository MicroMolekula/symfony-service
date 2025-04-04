<?php

namespace App\Enum;

use App\Repository\EnumTargetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnumTargetRepository::class)]
enum EnumTarget: string
{
    case WEIGHT_LOSS = 'weight_loss';
    case MUSCLE_GAIN = 'muscle_gain';
    case ENDURANCE = 'endurance';
    case FLEXIBILITY = 'flexibility';
    case GENERAL_FITNESS = 'general_fitness';
    case REHABILITATION = 'rehabilitation';
    case PREGNANCY = 'pregnancy';


    public function getLabel(): string
    {
        return match($this) {
            self::WEIGHT_LOSS => 'Похудение',
            self::MUSCLE_GAIN => 'Набор мышечной массы',
            self::ENDURANCE => 'Развитие выносливости',
            self::FLEXIBILITY => 'Развитие гибкости',
            self::GENERAL_FITNESS => 'Общая физическая подготовка',
            self::REHABILITATION => 'Реабилитация',
            self::PREGNANCY => 'Для беременных',
        };
    }
}
