<?php
namespace Core\Traits;

trait ToDatabaseTrait {
    protected array $nonPersistedData = [];
    
    public function toDatabase(): array {
        $data = $this->toSqlArray();
        $data = array_filter($data, fn($k) => !in_array($k, $this->nonPersistedData), ARRAY_FILTER_USE_KEY);
        
        foreach ($data as $key => $value) {
            if (is_array($value)) unset($data[$key]);
        }
        
        return $data;
    }
    
    public function setNonPersistedData(array $nonPersistedData): void {
        $this->nonPersistedData = $nonPersistedData;
    }
}