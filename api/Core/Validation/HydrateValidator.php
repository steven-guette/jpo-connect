<?php
namespace Core\Validation;

use Core\Security\WhiteShield;
use Core\Exceptions\ValidationException;
use Dotenv\Exception\InvalidFileException;
use Exception;

final class HydrateValidator {
    private array $rules;
    private array $labels;
    
    private array $errors = [];
    
    /**
     * @param string $entityName
     * @throws Exception
     */
    public function __construct(string $entityName) {
        $entityName = lcfirst($entityName);
        $config_filepath = __DIR__ . "/../../config/validation/$entityName.php";
        if (file_exists($config_filepath)) {
            $config = require $config_filepath;
            $this->rules = $config['rules'] ?? [];
            $this->labels = $config['labels'] ?? [];
        }
    }
    
    public function validate(array $data): void {
        if (empty($this->rules)) return;
        foreach ($data as $key => $value) {
            if (!isset($this->rules[$key]) || is_null($value)) continue;
            foreach ($this->rules[$key] as $method => $params) {
                if (isset($this->rules[$key])
                    && method_exists(WhiteShield::class, $method)
                    && !WhiteShield::$method($value, ...$params)) {
                    $this->setErrors($key, $method);
                }
            }
        }
    }
    
    /**
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    public function assertValid(array $data): void {
        $this->validate($data);
        if ($this->hasError()) {
            throw new ValidationException($this->getErrors());
        }
    }
    
    public function hasError(): bool {
        return count($this->errors) > 0;
    }
    
    private function setErrors(string $key, string $method): void {
        $label = isset($this->labels[$key]) ? ucfirst($this->labels[$key]) : $key;
        $message = match ($method) {
            'isNotEmpty'        => "Votre $label est obligatoire.",
            'hasMaxLength'      => "Votre $label est trop long.",
            'hasMinLength'      => "Votre $label est trop court.",
            'hasLowerCase'      => "Votre $label doit contenir au moins une minuscule.",
            'hasUpperCase'      => "Votre $label doit contenir au moins une majuscule.",
            'hasDigit'          => "Votre $label doit contenir au moins un chiffre.",
            'hasSpecialChar'    => "Votre $label doit contenir au moins un caractère spécial.",
            default             => "Votre $label est invalide."
        };
        $this->errors[$key][] = $message;
    }
    
    public function getErrors(): array {
        return $this->errors;
    }
}