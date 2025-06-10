<?php
namespace Contracts;

interface ModelInterface {
    public function findAll(array $filters): ?array;
    public function findById(int $id): ?object;
    public function save(object $entity): int|bool;
    public function edit(object $entity, bool $overwrite = false): bool;
    public function modify(object $entity): bool;
    public function change(object $entity): bool;
    public function remove(object $entity): bool;
}