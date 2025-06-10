<?php
namespace App\Services;

use App\Enums\RoleEnum;
use App\Entities\User;
use App\Models\UsersModel;
use App\Policies\PolicyGuard;
use App\Policies\UserPolicy;
use Core\Exceptions\ValidationException;
use Core\Security\PasswordManager;
use Core\Security\AuthContext;
use Core\Service\BaseService;
use Exception;

final class UsersService extends BaseService {
    public function __construct() {
        parent::__construct(User::class, new UsersModel());
    }
    
    /**
     * @param int $id
     * @return bool|object|null
     * @throws Exception
     */
    public function getEntity(int $id): null|bool|User {
        $user = $this->modelObj->findById($id);
        $this->checkEntityType($user);
        PolicyGuard::authorize(UserPolicy::canRead(AuthContext::getCurrentUser(), $user));
        
        $user->clearPassword();
        return $user;
    }

    /**
     * @param array $filters
     * @return bool|array
     * @throws Exception;
     */
    public function getAllEntities(array $filters): bool|array {
        $currentUser = AuthContext::getCurrentUser();
        $users = !$currentUser || $currentUser->isVisitor()
            ? $this->modelObj->getPublicList($filters)
            : $this->modelObj->findAll($filters);

        $this->checkEntityType($users);
        return array_map(function($user) {
            $user->clearPassword();
            return $user;
        }, $users);
    }

    /**
     * @param User $entity
     * @return int|bool
     * @throws Exception
     */
    public function addEntity(User $entity): int|bool {
        $this->checkEntityType($entity);
        $currentUser = AuthContext::getCurrentUser();
        PolicyGuard::authorize(UserPolicy::canCreate($currentUser));
        
        if ($entity->getEmail()) {
            $this->checkMail($entity->getEmail());
        }
        
        if (!$currentUser || !$currentUser->isDirector()) {
            $entity->setRoleId(RoleEnum::Visitor->value);
        }
        $entity->setPassword(PasswordManager::hash($entity->getPassword()));
        
        return $this->modelObj->save($entity);
    }
    
    /**
     * @param User $entity
     * @param bool $overwrite
     * @return bool
     * @throws Exception
     */
    public function updateEntity(User $entity, bool $overwrite): bool {
        $this->checkEntityType($entity);
        PolicyGuard::authorize(UserPolicy::canUpdate(AuthContext::getCurrentUser(), $entity));
        
        if ($entity->getPassword()) {
            $entity->setPassword(null);
        }
        
        if ($entity->getEmail()) {
            $currentUser = AuthContext::getCurrentUser();
            if ($currentUser->isDirector() || $entity->getEmail() === $currentUser->getEmail()) {
                $entity->setEmail(null);
            }else {
                $this->checkMail($entity->getEmail());
            }
        }
        
        return $this->modelObj->edit($entity, $overwrite);
    }
    
    /**
     * @param User $entity
     * @return bool
     * @throws Exception
     */
    public function deleteEntity(User $entity): bool {
        $this->checkEntityType($entity);
        PolicyGuard::authorize(UserPolicy::canDelete(AuthContext::getCurrentUser(), $entity));
        return $this->modelObj->remove($entity);
    }
    
    /**
     * @param string $mail
     * @return void
     * @throws ValidationException
     */
    private function checkMail(string $mail): void {
        if ($this->modelObj->emailAlreadyExists($mail)) {
            throw new ValidationException(['Vous ne pouvez pas réutiliser une adresse email déjà enregistrée.']);
        }
    }
}