<?php
namespace Core\Exceptions;

use Exception;

final class RegistrationException extends Exception {
    public function __construct(string $message) {
        parent::__construct($message, 409);
    }
}