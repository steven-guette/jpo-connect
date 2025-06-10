<?php
namespace App\Services;

use App\Entities\Comment;
use App\Policies\PolicyGuard;
use App\Policies\CommentPolicy;
use App\Models\CommentsModel;
use Core\Validation\EntityValidator;
use Core\Service\CrudService;
use Core\Security\AuthContext;
use Exception;

final class CommentsService extends CrudService {
    public function __construct() {
        parent::__construct(Comment::class, new CommentsModel());
    }
    
    /**
     * @param object $entity
     * @return int|bool
     * @throws Exception
     */
    public function addEntity(object $entity): int|bool {
        EntityValidator::checkType($entity, Comment::class);
        PolicyGuard::authorize(CommentPolicy::canCreate(AuthContext::isAuthenticated()));
        return $this->modelObj->save($entity);
    }
    
    /**
     * @param object $entity
     * @param bool $overwrite
     * @return bool
     * @throws Exception
     */
    public function updateEntity(object $entity, bool $overwrite): bool {
        EntityValidator::checkType($entity, Comment::class);
        PolicyGuard::authorize(CommentPolicy::canUpdate(AuthContext::getCurrentUser(), $entity));
        return $this->modelObj->edit($entity, $overwrite);
    }
    
    /**
     * @param object $entity
     * @return bool
     * @throws Exception
     */
    public function deleteEntity(object $entity): bool {
        EntityValidator::checkType($entity, Comment::class);
        PolicyGuard::authorize(CommentPolicy::canDelete(AuthContext::getCurrentUser()));
        return $this->modelObj->remove($entity);
    }
}