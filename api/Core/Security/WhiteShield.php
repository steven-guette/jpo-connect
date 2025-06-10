<?php
namespace Core\Security;

final class WhiteShield {
    static function isNotEmpty(mixed $value): bool {
        return !empty($value);
    }
    
    static function isInt(mixed $value): bool {
        return is_int($value);
    }
    
    static function isFloat(mixed $value): bool {
        return is_float($value);
    }
    
    static function isPositive(int|float $value): bool {
        return $value > 0;
    }
    
    static function isNegative(int|float $value): bool {
        return $value < 0;
    }
    
    static function isEqual(int|float $value1, int|float $value2): bool {
        return $value1 === $value2;
    }
    
    static function isLessThan(int|float $value, int|float $max): bool {
        return $value < $max;
    }
    
    static function isGreaterThan(int|float $value, int|float $min): bool {
        return $value > $min;
    }
    
    static function isBetween(int|float $value, int|float $min, int|float $max): bool {
        return $value >= $min && $value <= $max;
    }
    
    static function isString(mixed $value): bool {
        return is_string($value);
    }
    
    static function isHumanName(string $value): bool {
        return preg_match('/^[\p{L}\'\- ]+$/u', $value) === 1;
    }
    
    static function isZipCode(string $value): bool {
        return preg_match('/^\d{5}$/', $value) === 1;
    }
    
    static function isGPSCoordinates(string $value): bool {
        return preg_match('/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/', $value) === 1;
    }
    
    static function isEmail(string $value): bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    static function hasLength(string $value, int $length): bool {
        return mb_strlen($value) === $length;
    }
    
    static function hasMaxLength(string $value, int $max): bool {
        return mb_strlen($value) <= $max;
    }
    
    static function hasMinLength(string $value, int $min): bool {
        return mb_strlen($value) >= $min;
    }
    
    static function hasUpperCase(string $value): bool {
        return (bool) preg_match('/[A-Z]/u', $value);
    }
    
    static function hasLowerCase(string $value): bool {
        return (bool) preg_match('/[a-z]/u', $value);
    }
    
    static function hasDigit(string $value): bool {
        return (bool) preg_match('/\d/', $value);
    }
    
    static function hasSpecialChar(string $value): bool {
        return (bool) preg_match('/[^a-zA-Z\d]/u', $value);
    }
    
    static function inList(string $value, array $list): bool {
        return in_array($value, $list);
    }
}