<?php
namespace Core\Http;

use JetBrains\PhpStorm\NoReturn;

final class ApiResponse {
    #[NoReturn] public static function response(array $data, int $status): void {
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
    
    #[NoReturn] public static function error(string $message = '', mixed $errors = [], int $status = 400): void {
        self::response([
            'success'   => false,
            'message'   => self::getErrorMessage($message),
            'errors'    => $errors,
            'status'    => $status
        ], $status);
    }
    
    #[NoReturn] public static function success(string $message = '', mixed $data = [], int $status = 200): void {
        self::response([
            'success'   => true,
            'message'   => self::getSuccessMessage($message),
            'data'      => $data,
            'status'    => $status
        ], $status);
    }
    
    private static function getErrorMessage(string $key): string {
        return match ($key) {
            'read'      => 'Une erreur est survenue lors de la récupération des données',
            'update'    => 'Une erreur est survenue lors de la modification des données.',
            'add'       => 'Une erreur est survenue lors de l\'enregistrement.',
            'delete'    => 'Une erreur est survenue lors de la suppression.',
            default     => $key
        };
    }
    
    private static function getSuccessMessage(string $key): string {
        return match ($key) {
            'read'      => 'Les données ont été récupérées.',
            'update'    => 'Les données ont été modifiées.',
            'add'       => 'Les données ont été ajoutés.',
            'delete'    => 'Les données ont été supprimées.',
            default     => $key
        };
    }
}