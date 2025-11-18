<?php
namespace Core;

class Validator
{
    public static function string(string $value, int $min = 1, $max = INF): bool
    {
        // Trim whitespace, This prevents empty/spaces from being counted towards length 
        $value = trim($value);

        // Calculate the actual length of the trimmed string
        $length = strlen($value);

        return $length >= $min && $length <= $max;
    }

    public static function email(string $value)
    {
        // Use PHP's built-in filter_var() function to validate the email format.
        // FILTER_VALIDATE_EMAIL checks if the input follows the standard email pattern.
        // It returns the filtered data (the email) if valid, or false if invalid.
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}