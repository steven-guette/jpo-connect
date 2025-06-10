<?php
namespace App\Services;

use App\Entities\Location;
use App\Models\LocationsModel;
use App\Policies\PolicyGuard;
use App\Policies\LocationPolicy;
use Core\Service\CrudService;
use Core\Security\AuthContext;
use Exception;

final class LocationsService extends CrudService {
    public function __construct() {
        parent::__construct(Location::class, new LocationsModel());
    }

    /**
     * @param object $entity
     * @return int|bool
     * @throws Exception
     */
    public function addEntity(object $entity): int|bool {
        $this->checkEntityType($entity);
        PolicyGuard::authorize(LocationPolicy::canCreate(AuthContext::getCurrentUser()));
        return $this->modelObj->save($entity);
    }

    /**
     * @param object $entity
     * @param bool $overwrite
     * @return bool
     * @throws Exception
     */
    public function updateEntity(object $entity, bool $overwrite): bool {
        $this->checkEntityType($entity);
        PolicyGuard::authorize(LocationPolicy::canUpdate(AuthContext::getCurrentUser()));
        return $this->modelObj->edit($entity, $overwrite);
    }

    /**
     * @param object $entity
     * @return bool
     * @throws Exception
     */
    public function deleteEntity(object $entity): bool {
        $this->checkEntityType($entity);
        PolicyGuard::authorize(LocationPolicy::canDelete(AuthContext::getCurrentUser()));
        return $this->modelObj->remove($entity);
    }
}