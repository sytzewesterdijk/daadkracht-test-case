<?php

namespace App\Enums;

enum Status: int
{
    case Pending = 0;
    case Approved = 1;
    case Rejected = 2;

    public static function getLabel($value): string
    {
        return match ($value) {
            self::Pending->value => 'Pending',
            self::Approved->value => 'Approved',
            self::Rejected->value => 'Rejected',
        };
    }

    public static function getColor($value): string
    {
        return match ($value) {
            self::Pending->value  => 'yellow',
            self::Approved->value => 'green',
            self::Rejected->value => 'red',
        };
    }
}
