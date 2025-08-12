<?php

namespace App\Enums;
enum EmploymentType : string
{
    case FullTime = 'full_time';
    case PartTime = 'part_time';


    public function label(): string
    {
        return match ($this) {
            self::FullTime => __('enums.employment_type.' . self::FullTime->value),
            self::PartTime => __('enums.employment_type.' . self::PartTime->value),
        };
    }
}
