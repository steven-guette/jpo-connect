<?php
namespace Core\Service;

use Core\Validation\EntityValidator;

abstract class BaseService {
    protected string $entityClass;
    protected object $modelObj;

    
    public function __construct(string $entityClass, object $modelObj) {
        $this->setEntityClass($entityClass);
        $this->setModelObj($modelObj);
    }
    
    private function setEntityClass(string $entityClass): void {
        $this->entityClass = $entityClass;
    }

    private function setModelObj(object $modelObj): void {
        $this->modelObj = $modelObj;
    }

    protected function checkEntityType(mixed $entity): void {
        EntityValidator::checkType($entity, $this->entityClass);
    }
}