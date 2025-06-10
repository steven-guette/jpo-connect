<?php
namespace Core\Exceptions;

use Exception;

final class AuthenticationException extends Exception {
    public function __construct(string $message = 'Il est impossible de vous authentifier.') {
        parent::__construct($message, 401);
    }
}