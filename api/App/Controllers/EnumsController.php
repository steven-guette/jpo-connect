<?php
namespace App\Controllers;

use Core\Http\ApiResponse;
use UnitEnum;
use Exception;

final class EnumsController {
    /**
     * @param string $enumName
     * @return void
     * @throws Exception
     */
    public static function get(string $enumName): void {
        $enumData = self::getEnumData(ucfirst($enumName));
        if (!$enumData) {
            throw new Exception("Enum $enumName inexistant.");
        }
        ApiResponse::success('', $enumData);
    }
    
    private static function getEnumData(string $enumClass): ?array {
        $enum = "App\\Enums\\$enumClass";
        
        if (!enum_exists($enum) || !is_subclass_of($enum, UnitEnum::class)) {
            return null;
        }
        
        return array_map(fn($case) => [
            'id' => $case->value,
            'key' => $case->name,
            'label' => method_exists($case, 'label') ? $case->label() : $case->name,
        ], $enum::cases());
    }
}