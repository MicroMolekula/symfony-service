<?php

namespace App\Enum;


enum EnumTarget: string
{
    case GET_STRONGER = 'get_stronger';
    case MAINTAIN_SHAPE = 'maintain_shape';
    case GET_SLIM = 'get_slim';


    public function getLabel(): string
    {
        return match($this) {
            self::GET_STRONGER => 'Стать сильнее',
            self::MAINTAIN_SHAPE => 'Поддержать форму',
            self::GET_SLIM => 'Стать стройнее',
        };
    }
}
