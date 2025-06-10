<?php
namespace Core\Validation;

use UnexpectedValueException;

final class EntityValidator {
    public static function checkType(mixed $entity, string $expectedClass): void {
        if (!is_array($entity)) $entity = [$entity];
        foreach ($entity as $e) {
            if (!$e instanceof $expectedClass) {
                throw new UnexpectedValueException("Une instance de $expectedClass est attendue : " . get_class($e) . " fournie.");
            }
        }
    }
}