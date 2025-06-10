<?php
namespace Core\Security;

use Exception;
use App\Models\AuthModel;
use App\Entities\User;
use App\Enums\RoleEnum;

final class AuthContext {
    public static function isAuthenticated(): bool {
        return isset($_SESSION['user_id']);
    }
    
    public static function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * @return ?User
     * @throws Exception
     */
    public static function getCurrentUser(): ?User {
        return self::isAuthenticated() ? (new AuthModel())->getUserById(self::getUserId()) : null;
    }
    
    /**
     * @param RoleEnum $role
     * @return bool
     * @throws Exception
     */
    public static function userHasRole(RoleEnum $role): bool {
        $user = self::getCurrentUser();
        return $user->getRole() === $role;
    }
}