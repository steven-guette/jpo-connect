<?php
namespace Core\Model;

use Core\Http\ApiResponse;
use Exception;
use App\Entities\User;
use Contracts\ModelInterface;

abstract class CrudModel extends BaseModel implements ModelInterface {
    public function __construct(string $tableName, string $entityClass) {
        parent::__construct($tableName, $entityClass);
    }

    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function findAll(array $filters): array {
        $data = $this->readAll($filters);
        return $this->mapEntities($data);
    }

    /**
     * @param int $id
     * @return ?User
     * @throws Exception
     */
    public function findById(int $id): ?object {
        $data = $this->readOne(['id' => $id]);
        return $this->mapEntity($data);
    }

    /**
     * @param object $entity
     * @return int|bool
     * @throws Exception
     */
    public function save(object $entity): int|bool {
        $data = $entity->toDatabase();
        return $this->create($data);
    }

    /**
     * @param object $entity
     * @param bool $overwrite
     * @return bool
     * @throws Exception
     */
    public function edit(object $entity, bool $overwrite = false): bool {
        return $overwrite ? $this->change($entity) : $this->modify($entity);
    }

    /**
     * @param object $entity
     * @return bool
     * @throws Exception
     */
    public function modify(object $entity): bool {
        $data = array_filter($entity->toDatabase(), fn($value) => !is_null($value));
        unset($data['id']);
        return $this->update($entity->getId(), $data);
    }

    /**
     * @param object $entity
     * @return bool
     * @throws Exception
     */
    public function change(object $entity): bool {
        $data = $entity->toDatabase();
        unset($data['id']);
        return $this->update($entity->getId(), $data);
    }

    /**
     * @param object $entity
     * @return bool
     * @throws Exception
     */
    public function remove(object $entity): bool {
        return $this->delete($entity->getId());
    }
}