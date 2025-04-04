<?php

namespace App\Enum;

enum EnumAllergy: string
{
    case PEANUTS = 'peanuts';
    case SHELLFISH = 'shellfish';
    case DAIRY = 'dairy';
    case GLUTEN = 'gluten';
    case EGGS = 'eggs';
    case SOY = 'soy';
    case FISH = 'fish';
    case TREE_NUTS = 'tree_nuts';
    case SESAME = 'sesame';
    case MUSTARD = 'mustard';

    public function getLabel(): string
    {
        return match($this) {
            self::PEANUTS => 'Арахис',
            self::SHELLFISH => 'Моллюски',
            self::DAIRY => 'Молочные продукты',
            self::GLUTEN => 'Глютен',
            self::EGGS => 'Яйца',
            self::SOY => 'Соя',
            self::FISH => 'Рыба',
            self::TREE_NUTS => 'Орехи',
            self::SESAME => 'Кунжут',
            self::MUSTARD => 'Горчица',
        };
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getLabels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->getLabel();
        }
        return $labels;
    }
}