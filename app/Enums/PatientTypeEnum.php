<?php

namespace App\Enums;

use Illuminate\Support\Facades\Lang;

enum PatientTypeEnum: string
{
    case CAT = 'cat';
    case DOG = 'dog';
    case RABBIT = 'rabbit';
    case SNAKE = 'snak';

    public function label(): string
    {
        return Lang::get("enums." . self::class . "." . $this->name);
    }
}
