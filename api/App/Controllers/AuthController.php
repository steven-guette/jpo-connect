<?php
namespace App\Controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use App\Services\AuthService;
use Core\Http\ApiResponse;

final class AuthController {
    private AuthService $authService;
    
    public function __construct() {
        $this->authService = new AuthService();
    }
    
    /**
     * @param string $email
     * @param string $password
     * @return void
     * @throws Exception
     */
    #[NoReturn] public function login(string $email, string $password): void {
        $this->authService->login($email, $password);
        ApiResponse::success('Vous êtes désormais connecté.', $this->authService->getCurrentUser());
    }

    #[NoReturn] public function logout(): void {
        $this->authService::logout();
        ApiResponse::success('Vous êtes désormais déconnecté.');
    }
    
    /**
     * @return void
     * @throws Exception
     */
    #[NoReturn] public function me(): void {
        ApiResponse::success('Profil utilisateur récupéré.', $this->authService->getCurrentUser());
    }
    
    /**
     * @param string $current
     * @param string $new
     * @return void
     * @throws Exception
     */
    #[NoReturn] public function changePass(string $current, string $new): void {
        $this->authService->changePassword($current, $new);
        ApiResponse::success('Mot de passe modifié');
    }
}