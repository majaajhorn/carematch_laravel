<?php

namespace App\Enums;
enum SalaryPeriod : string
{
    case Weekly = 'weekly';
    case Monthly = 'monthly';


    public function label(): string
    {
        return match ($this) {
            self::Weekly => __('enums.salary_period.' . self::Weekly->value),
            self::Monthly => __('enums.salary_period.' . self::Monthly->value),
        };
    }
}
