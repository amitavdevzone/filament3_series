<?php

namespace App\Enums;

/**
 * Adding a base trait for all enums to use
 * and keep a single source.
 *
 * Ref: https://stackoverflow.com/a/71680007
 */
trait BaseEnum
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
