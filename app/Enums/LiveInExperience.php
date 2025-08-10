<?php

namespace App\Enums;
enum LiveInExperience : string
{
    case LessThan3Years = 'one_to_three_years';
    case LessThan5Years = 'three_to_five_years';
    case MoreThan5Years = 'more_than_five_years';

    public function label(): string
    {
        return match ($this) {
            self::LessThan3Years => __('enums.experience.' . self::LessThan3Years->value),
            self::LessThan5Years => __('enums.experience.' . self::LessThan5Years->value),
            self::MoreThan5Years => __('enums.experience.' . self::MoreThan5Years->value),
        };
    }
}

