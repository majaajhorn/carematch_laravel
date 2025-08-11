<?php

namespace App\Enums;
enum EmploymentType : string
{
    case FullTime = 'full time';
    case PartTime = 'part time';


    public function label(): string
    {
        return match ($this) {
            self::FullTime => __('enums.employment_type.' . self::FullTime->value),
            self::PartTime => __('enums.employment_type.' . self::PartTime->value),
        };
    }
}
