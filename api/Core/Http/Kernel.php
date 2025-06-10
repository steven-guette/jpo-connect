<?php
namespace Core\Http;

use Core\Exceptions\AuthenticationException;
use Core\Exceptions\AuthorizationException;
use Core\Exceptions\RegistrationException;
use Core\Exceptions\ValidationException;
use Throwable;

final class Kernel {
    private Router $router;
    
    public function __construct() {
        $this->router = new Router();
    }
    
    public function run(): void {
        try {
            $this->router->dispatch();
        } catch (AuthenticationException|AuthorizationException|RegistrationException $e) {
            ApiResponse::error($e->getMessage(), [], $e->getCode());
        } catch (ValidationException $e) {
            ApiResponse::error($e->getMessage(), $e->getErrors(), $e->getCode());
        } catch (Throwable $e) {
            ApiResponse::error('Une erreur interne est survenue.', [
                'type'    => get_class($e),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ], 500);
        }
    }
}