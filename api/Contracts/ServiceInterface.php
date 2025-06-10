<?php
namespace Contracts;

interface ServiceInterface {
    public function getEntity(int $id): null|bool|object;
    public function getAllEntities(array $filters): bool|array;
    public function addEntity(object $entity): int|bool;
    public function updateEntity(object $entity, bool $overwrite): bool;
    public function deleteEntity(object $entity): bool;
}