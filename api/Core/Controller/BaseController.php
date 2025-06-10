<?php
namespace Core\Controller;

abstract class BaseController {
    protected object $serviceObj;
    protected string $entityClass;

    public function __construct(object $serviceObj, string $entityClass) {
        $this->setServiceObj($serviceObj);
        $this->setEntityClass($entityClass);
    }
    
    private function setServiceObj(object $serviceObj): void {
        $this->serviceObj = $serviceObj;
    }
    
    private function setEntityClass(string $entityClass): void {
        $this->entityClass = $entityClass;
    }
}