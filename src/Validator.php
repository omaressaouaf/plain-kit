<?php


declare(strict_types=1);

namespace Omaressaouaf\PlainKit;

class Validator
{
    public static function exists(mixed $value)
    {
        return !empty($value);
    }

    public static function in(mixed $value, array $array)
    {
        return in_array($value, $array);
    }

    public static function string(string $value)
    {
        return is_string(trim($value));
    }

    public static function numeric(mixed $value)
    {
        return is_numeric($value);
    }

    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function min(mixed $value, int $min): bool
    {
        if (is_numeric($value)) {
            return $value >= $min;
        }

        if (is_string($value)) {
            return strlen($value) >= $min;
        }

        if (is_array($value)) {
            return count($value) >= $min;
        }

        return $value >= $min;
    }

    public static function max(mixed $value, int $max): bool
    {
        if (is_string($value)) {
            return strlen($value) <= $max;
        }

        if (is_array($value)) {
            return count($value) <= $max;
        }

        return $value <= $max;
    }
}
