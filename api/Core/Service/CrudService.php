<?php
namespace Core\Service;

use Contracts\ServiceInterface;

abstract class CrudService extends BaseService implements ServiceInterface {
    public function __construct(string $entityClass, object $modelObj) {
        parent::__construct($entityClass, $modelObj);
    }
    
    public function getEntity(int $id): null|bool|object {
        $obj = $this->modelObj->findById($id);
        $this->checkEntityType($obj);
        return $obj;
    }
    
    public function getAllEntities(array $filters): bool|array {
        $objects = $this->modelObj->findAll($filters);
        $this->checkEntityType($objects);
        return $objects;
    }
    
    public function addEntity(object $entity): int|bool {
        $this->checkEntityType($entity);
        return $this->modelObj->save($entity);
    }
    
    public function updateEntity(object $entity, bool $overwrite): bool {
        $this->checkEntityType($entity);
        return $this->modelObj->edit($entity, $overwrite);
    }
    
    public function deleteEntity(object $entity): bool {
        $this->checkEntityType($entity);
        return $this->modelObj->remove($entity);
    }
}