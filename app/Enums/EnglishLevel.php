<?php

namespace App\Enums;
enum EnglishLevel : string
{
    case Basic = 'basic';
    case Intermediate = 'intermediate';
    case Advanced = 'advanced';

    public function label(): string
    {
        return match ($this) {
            self::Basic => __('enums.english_level.' . self::Basic->value),
            self::Intermediate => __('enums.english_level.' . self::Intermediate->value),
            self::Advanced => __('enums.english_level.' . self::Advanced->value),
        };
    }
}
