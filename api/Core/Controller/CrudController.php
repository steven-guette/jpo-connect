<?php
namespace Core\Controller;

use JetBrains\PhpStorm\NoReturn;
use Core\Http\ApiResponse;
use Contracts\ControllerInterface;
use InvalidArgumentException;

abstract class CrudController extends BaseController implements ControllerInterface {
    public function __construct(object $serviceObj, string $entityClass) {
        parent::__construct($serviceObj, $entityClass);
    }
    
    #[NoReturn] public function index(array $filters = []): void {
        $result = $this->serviceObj->getAllEntities($filters);
        ApiResponse::success('read', $result);
    }
    
    #[NoReturn] public function show(int $id): void {
        $result = $this->serviceObj->getEntity($id);
        ApiResponse::success('read', $result);
    }
    
    #[NoReturn] public function store(array $data): void {
        $result = $this->serviceObj->addEntity(new $this->entityClass($data));
        ApiResponse::success('add', $result);
    }

    #[NoReturn] public function modify(array $data, bool $overwrite = false): void {
        if (!isset($data['id'])) {
            throw new InvalidArgumentException("Impossible de modifier une entité sans son id.");
        }
        
        $this->serviceObj->updateEntity(new $this->entityClass($data), $overwrite);
        ApiResponse::success('update');
    }
    
    #[NoReturn] public function destroy(int $id): void {
        $this->serviceObj->deleteEntity(new $this->entityClass(['id' => $id]));
        ApiResponse::success('delete');
    }
}