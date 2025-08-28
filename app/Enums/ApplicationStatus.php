<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => ('enums.status.' . self::Pending->value),
            self::Approved => ('enums.status.' . self::Approved->value),
            self::Rejected => ('enums.status.' . self::Rejected->value),
        };
    }

    /**
     * CSS styling za tagove
     */
    public function getBadgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-100 text-yellow-800',
            self::Approved => 'bg-green-100 text-green-800',
            self::Rejected => 'bg-red-100 text-red-800',
        };
    }
}
