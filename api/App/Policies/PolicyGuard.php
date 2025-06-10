<?php
namespace App\Policies;

use Core\Exceptions\AuthorizationException;

final class PolicyGuard {
    
    /**
     * @param bool $condition
     * @param string $message
     * @return void
     * @throws AuthorizationException
     */
    static function authorize(bool $condition, string $message = 'Vous ne disposez pas des droits nécessaires.'): void {
        if (!$condition) throw new AuthorizationException($message);
    }
}