<?php

namespace App\Enums;

enum PatientTypeEnum: string
{
    case CAT = 'cat';
    case DOG = 'dog';
    case RABBIT = 'rabbit';
    case SNAKE = 'snak';

    public function label(): string
    {
        return match($this) {
            self::CAT => 'گربه',
            self::DOG => 'سگ',
            self::RABBIT => 'خرگوش',
            self::SNAKE => 'مار',
        };
    }
}
