<?php

namespace App\Enums;
enum Gender : string
{
    case Female = 'female';
    case Male = 'male';
    case Other = 'other';

   public function label(): string
   {
        return match ($this) {
            self::Female => __('enums.gender.' . self::Female->value),
            self::Male => __('enums.gender.' . self::Male->value),
            self::Other => __('enums.gender.' . self::Other->value),
        };
   }
}


