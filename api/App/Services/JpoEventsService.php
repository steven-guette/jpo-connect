<?php
namespace App\Services;

use App\Enums\JpoStatusEnum;
use App\Policies\PolicyGuard;
use App\Policies\JpoEventPolicy;
use App\Entities\JpoEvent;
use App\Models\JpoEventsModel;
use Core\Security\AuthContext;
use Core\Validation\EntityValidator;
use Core\Service\CrudService;
use Exception;

final class JpoEventsService extends CrudService {
    public function __construct() {
        parent::__construct(JpoEvent::class, new JpoEventsModel());
    }
    
    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getEntities(array $filters): array {
        $events = $this->modelObj->findAll($filters);
        EntityValidator::checkType($events, JpoEvent::class);
        
        $this->editExpiredEvents($events);
        
        $statusFk = $filters['status_fk'] ?? null;
        if (!$statusFk || (int)$statusFk !== JpoStatusEnum::Archived->value) {
            return array_filter($events, fn(JpoEvent $event) => !$event->isArchived());
        }
        return $events;
    }
    
    /**
     * @param object $entity
     * @return int|bool
     * @throws Exception
     */
    public function addEntity(object $entity): int|bool {
        EntityValidator::checkType($entity, JpoEvent::class);
        PolicyGuard::authorize(JpoEventPolicy::canCreate(AuthContext::getCurrentUser(), $entity));
        return $this->modelObj->save($entity);
    }
    
    /**
     * @param object $entity
     * @param $overwrite
     * @return bool
     * @throws Exception
     */
    public function updateEvent(object $entity, $overwrite): bool {
        EntityValidator::checkType($entity, JpoEvent::class);
        PolicyGuard::authorize(JpoEventPolicy::canUpdate(AuthContext::getCurrentUser(), $entity));
        return $this->modelObj->edit($entity, $overwrite);
    }
    
    /**
     * @param object $entity
     * @return bool
     * @throws Exception
     */
    public function deleteEvent(object $entity): bool {
        EntityValidator::checkType($entity, JpoEvent::class);
        PolicyGuard::authorize(JpoEventPolicy::canDelete(AuthContext::getCurrentUser(), $entity));
        return $this->modelObj->remove($entity);
    }
    
    public function subscribeToEvent(int $jpoEventId): bool {
        return $this->modelObj->addRegistration($jpoEventId);
    }
    
    public function unsubscribeToEvent(int $jpoEventId): bool {
        return $this->modelObj->removeRegistration($jpoEventId);
    }
    
    /**
     * @param array $events
     * @return void
     * @throws Exception
     */
    private function editExpiredEvents(array $events): void {
        foreach ($events as $event) {
            $eventEndDatetime = $event->getEndDatetimeObject();
            if (!$event->isArchived() && $eventEndDatetime && $eventEndDatetime->getTimestamp() < time()) {
                $event->setStatusFk(JpoStatusEnum::Archived->value);
                $this->modelObj->edit($event, false);
            }
        }
    }
}