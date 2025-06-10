<?php
namespace Core\Exceptions;

use Exception;

final class AuthorizationException extends Exception {
    public function __construct(string $message) {
        parent::__construct($message, 403);
    }
}