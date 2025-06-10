<?php
namespace Contracts;

interface ControllerInterface {
    public function index(array $filters = []): void;
    public function show(int $id): void;
    public function store(array $data): void;
    public function modify(array $data, bool $overwrite = false): void;
    public function destroy(int $id): void;
}