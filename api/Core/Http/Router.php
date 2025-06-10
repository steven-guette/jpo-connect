<?php
namespace Core\Http;

use Exception;
use Symfony\Component\VarDumper\VarDumper;

final class Router {
    private string $requestMethod;
    private array $uriComponents;
    private object $controller;
    private array $params;
    private array $data;
    private ?int $id;
    
    /**
     * @throws Exception
     */
    public function __construct() {
        $this->initialize();
    }
    
    /**
     * @return void
     * @throws Exception
     */
    public function dispatch(): void {
        if ($this->isSpecialController()) {
            switch ($this->getControllerName()) {
                case 'AuthController':
                    $controllerMethod = $this->getUriComponents(1) ?? null;
                    if (!method_exists($this->getController(), $controllerMethod)) {
                        throw new Exception("{$this->getControllerName()} : La méthode $controllerMethod n'existe pas.");
                    }
                    
                    call_user_func_array([$this->getController(), $controllerMethod], array_values($this->getData()));
                    break;
                    
                case 'EnumsController':
                    $enumName = $this->getUriComponents(1) ?? null;
                    if (!$enumName) {
                        throw new Exception("EnumsController : Le nom de l'énumération n'est pas renseigné.");
                    }
                    $this->getController()->get($enumName);
                    break;
            }
            return;
        }
        
        switch ($this->getRequestMethod()) {
            case 'GET':
                if ($this->getId()) {
                    $this->getController()->show($this->getId());
                }
                $this->getController()->index($this->getParams());
                break;
                
            case 'POST':
                $this->getController()->store($this->getData());
                break;
                
            case 'PUT':
                $this->getController()->modify($this->getData(), true);
                break;
                
            case 'PATCH':
                $this->getController()->modify($this->getData(), false);
                break;
                
            case 'DELETE':
                $this->getController()->destroy($this->getId());
                break;
                
            default:
                throw new Exception("La méthode $this->requestMethod n'est pas prise en charge.");
        }
    }
    
    /**
     * @return void
     * @throws Exception
     */
    private function initialize(): void {
        $this->setRequestMethod();
        $this->setUriComponents();
        $this->setController();
        $this->setParams();
        $this->setData();
        $this->setId();
    }
    
    private function isSpecialController(): bool {
        return in_array($this->getControllerName(), SPECIALS_ROUTES);
    }
    
    private function dataKeyExists(array $keys): bool {
        foreach ($keys as $key) if (!isset($this->getData()[$key])) return false;
        return true;
    }
    
    public function getControllerName(): string {
        return ucfirst($this->uriComponents[0]) . 'Controller';
    }
    
    private function setRequestMethod(): void {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }
    public function getRequestMethod(): string {
        return $this->requestMethod;
    }
    
    private function setUriComponents(): void {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $route = trim(str_replace(ROUTE_BASE, '', $uri), '/');
        $this->uriComponents = explode('/', $route);
    }
    public function getUriComponents(?int $index = null): array|string {
        return !is_null($index) && isset($this->uriComponents[$index])
            ? $this->uriComponents[$index]
            : $this->uriComponents;
    }
    
    /**
     * @return void
     * @throws Exception
     */
    private function setController(): void {
        $controllerClass = "App\\Controllers\\{$this->getControllerName()}";
        if (!class_exists($controllerClass)) {
            throw new Exception("La classe $controllerClass n'existe pas.");
        }
        $this->controller = new $controllerClass();
    }
    public function getController(): object {
        return $this->controller;
    }
    
    private function setId(): void {
        $this->id = isset($this->uriComponents[1]) && self::containsInteger($this->uriComponents[1])
            ? (int) $this->uriComponents[1]
            : null;
    }
    public function getId(): ?int {
        return $this->id;
    }
    
    private function setParams(): void {
        $this->params = !empty($_GET) ? $_GET : [];
    }
    public function getParams(): array {
        return $this->params;
    }
    
    private function setData(): void {
        $this->data = json_decode(file_get_contents('php://input'), true) ?? [];
    }
    public function getData(): array {
        return $this->data;
    }
    
    public static function containsInteger(mixed $value): bool {
        return (bool) preg_match('/^[1-9][0-9]*$/', $value);
    }
}