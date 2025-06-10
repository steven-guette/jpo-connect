<?php
namespace Core\Exceptions;

use Exception;

final class ValidationException extends Exception {
    private array $errors;
    
    public function __construct(array $errors, string $message = 'Certaines données sont invalides.') {
        parent::__construct($message, 422);
        $this->errors = $errors;
    }
    
    public function getErrors(): array {
        return $this->errors;
    }
}