<?php
namespace App\Services;

use App\Models\RegistrationsModel;
use App\Policies\PolicyGuard;
use App\Policies\RegistrationPolicy;
use App\Entities\Registration;
use Core\Service\CrudService;
use Core\Security\AuthContext;
use Core\Validation\EntityValidator;
use Core\Exceptions\RegistrationException;
use Exception;

final class RegistrationsService extends CrudService {
    private NotificationsService $notificationsService;
    private JpoEventsService $jpoEventsService;
    
    public function __construct() {
        parent::__construct(Registration::class, new RegistrationsModel());
        $this->notificationsService = new NotificationsService();
        $this->jpoEventsService = new JpoEventsService();
    }
    
    /**
     * @param object $entity
     * @param bool $overwrite
     * @return bool
     * @throws Exception
     */
    public function updateEntity(object $entity, bool $overwrite): bool {
        EntityValidator::checkType($entity, Registration::class);
        PolicyGuard::authorize(RegistrationPolicy::canCreate(AuthContext::getCurrentUser(), $entity));
        
        if ($entity->getWasPresent() === $entity->getCanceled()) return false;
        
        $this->ensureCooldownRespected($entity);
        $this->hydrateRegistrationDependencies($entity);
        
        $registrationFromDB = $this->modelObj->findRegistration($entity);
        if ($registrationFromDB instanceof Registration) {
            if ($entity->getWasPresent() && $entity->getWasPresent() === $registrationFromDB->getWasPresent()) {
                throw new RegistrationException("Vous êtes déjà inscrit à cette journée portes ouvertes.");
            } else if ($entity->getCanceled() && $entity->getCanceled() === $registrationFromDB->getCanceled()) {
                throw new RegistrationException("Vous n'êtes pas encore inscrit à cette journée portes ouvertes.");
            }
            
            $entity->setId($registrationFromDB->getId());
            $registrationSuccess = $this->modelObj->edit($entity, $overwrite);
        } else {
            $registrationSuccess = $this->modelObj->save($entity);
        }
        
        if ($registrationSuccess) {
            $this->setEventCounterRegistration($entity->getJpoEventFk(), $entity->getWasPresent());
            $this->sendNotification($entity, $entity->getCanceled());
            return true;
        }
        
        return false;
    }
    
    /**
     * @param int $eventId
     * @param bool $add
     * @return void
     */
    private function setEventCounterRegistration(int $eventId, bool $add = true): void {
        if ($add) {
            $this->jpoEventsService->subscribeToEvent($eventId);
        } else {
            $this->jpoEventsService->unsubscribeToEvent($eventId);
        }
    }
    
    /**
     * @param Registration $registration
     * @param bool $cancellation
     * @return void
     * @throws Exception
     */
    private function sendNotification(Registration $registration, bool $cancellation = false): void {
        $this->notificationsService->notify($registration, $cancellation);
    }
    
    /**
     * @param object $entity
     * @return void
     * @throws Exception
     */
    private function ensureCooldownRespected(object $entity): void {
        if ($this->modelObj->wasRecentlyModified($entity)) {
            throw new RegistrationException('Vous avez déjà modifié votre participation récemment. Veuillez patienter.');
        }
    }
    
    /**
     * @param object $entity
     * @return void
     * @throws Exception
     */
    private function hydrateRegistrationDependencies(object $entity): void {
        $entity->setUser((new UsersService())->getEntity($entity->getUserFk()));
        $entity->setJpoEvent((new JpoEventsService())->getEntity($entity->getJpoEventFk()));
    }
}