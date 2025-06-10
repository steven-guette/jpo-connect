<?php
namespace App\Services;

use Exception;
use App\Models\AuthModel;
use App\Entities\User;
use Core\Security\PasswordManager;
use Core\Security\AuthContext;
use Core\Exceptions\AuthenticationException;

final class AuthService {
    private AuthModel $authModel;
    
    public function __construct() {
        $this->authModel = new AuthModel();
    }
    
    /**
     * @param string $email
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function login(string $email, string $password): bool {
        if (AuthContext::isAuthenticated()) {
            throw new AuthenticationException("Vous êtes déjà connecté.");
        }

        $user = $this->authModel->getUserByEmail($email);
        if (!$user || !PasswordManager::verify($password, $user->getPassword())) {
            unset($user);
            throw new AuthenticationException("Identifiants invalides.");
        }

        if (PasswordManager::needsRehash($user->getPassword())) {
            $user->setPassword(PasswordManager::hash($password));
            $this->authModel->refreshPassword($user);
        }

        $this->remember($user);
        return true;
    }
    
    /**
     * @param string $oldPassword
     * @param string $newPassword
     * @return bool
     * @throws Exception
     */
    public function changePassword(string $oldPassword, string $newPassword): bool {
        if (!AuthContext::isAuthenticated()) {
            throw new AuthenticationException("Connectez vous pour modifier votre mot de passe.");
        }
        
        $user = AuthContext::getCurrentUser();
        if (!PasswordManager::verify($oldPassword, $user->getPassword())) {
            throw new AuthenticationException('Votre ancien mot de passe est incorrect.');
        }
        
        $user->setPassword(PasswordManager::hash($newPassword));
        $this->authModel->refreshPassword($user);
        
        return true;
    }
    
    /**
     * @return User
     * @throws Exception
     */
    public function getCurrentUser(): User {
        if (!AuthContext::isAuthenticated()) {
            throw new AuthenticationException("Vous n'êtes pas connecté.");
        }
        
        $currentUser = AuthContext::getCurrentUser();
        $currentUser->clearPassword();
        return $currentUser;
    }

    public function remember(User $user): void {
        session_regenerate_id();
        $_SESSION['user_id'] = $user->getId();
    }
    
    public static function logout(): void {
        self::clearSession();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }

    private static function clearSession(): void {
        session_unset();
        session_destroy();
    }
}