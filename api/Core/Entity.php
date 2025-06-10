<?php
namespace Core;

use JsonSerializable;
use ReflectionClass;
use Core\Validation\HydrateValidator;
use Exception;

abstract class Entity implements JsonSerializable {
    private array $hidden = [];
    private array $filledProperties = [];
    
    /**
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }
    
    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function hydrate(array $data): void {
        $className = (new ReflectionClass(static::class))->getShortName();
        (new HydrateValidator($className))->assertValid($data);
        
        foreach ($data as $attributeName => $value) {
            if (str_contains($attributeName, '_')) {
                $attributeName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $attributeName))));
            }
            
            $attributeName = ucfirst($attributeName);
            $method = "set$attributeName";
            
            if (!is_null($value) && method_exists($this, $method)) {
                $this->$method($value);
                $this->filledProperties[] = $attributeName;
            }
        }
    }
    
    public function jsonSerialize(): array {
        return $this->toArray();
    }
    
    public function toArray(): array {
        $attributes = [];
        $reflection = new ReflectionClass(static::class);
        
        foreach ($reflection->getProperties() as $property) {
            $attributeName = $property->getName();
            if ($attributeName === 'nonPersistedData') continue;
            if (!in_array($attributeName, $this->hidden, true)) {
                $attributes[$attributeName] = $property->getValue($this);
            }
        }
        
        return $attributes;
    }
    
    public function toSqlArray(): array {
        $attributes = [];
        $reflection = new ReflectionClass(static::class);
        
        foreach ($reflection->getProperties() as $property) {
            $attributeName = $property->getName();
            $arrayKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $attributeName));
            $attributes[$arrayKey] = $property->getValue($this);
        }
        
        return $attributes;
    }
    
    protected function setHidden(array $attributes): void {
        $this->hidden = [ ...$this->hidden, ...$attributes ];
    }
    
    protected function getFilledProperties(): array {
        return $this->filledProperties;
    }
}