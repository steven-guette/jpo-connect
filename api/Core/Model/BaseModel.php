<?php
namespace Core\Model;

use Core\Database;

abstract class BaseModel extends Database {
    protected string $entityClass;

    public function __construct(string $tableName, string $entityClass) {
        parent::__construct($tableName);
        $this->setEntityClass($entityClass);
    }

    protected function mapEntity(array $data): object {
        return new $this->entityClass($data);
    }

    protected function mapEntities(array $data): array {
        return array_map([$this, 'mapEntity'], $data);
    }
    
    protected function fastHydrate(array &$sqlData, object $hydrateObj, string $prefix, bool $clearOldRows = true): void {
        $startOffset = strlen($prefix) + 1;
        $objData = [];
        
        foreach ($sqlData as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $objData[substr($key, $startOffset)] = $value;
                if ($clearOldRows) unset($sqlData[$key]);
            }
        }
        
        if (!empty($objData)) {
            $hydrateObj->hydrate($objData);
        }
    }
    
    protected function fastHydrateBatch(array &$sqlData, array $elements): void {
        foreach ($elements as $element) {
            $this->fastHydrate($sqlData, $element['object'], $element['prefix'], $element['clear'] ?? true);
        }
    }

    private function setEntityClass(string $entityClass): void {
        $this->entityClass = $entityClass;
    }
}