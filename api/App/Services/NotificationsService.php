<?php
namespace App\Services;

use App\Entities\Notification;
use App\Entities\Registration;
use App\Entities\User;
use App\Models\NotificationsModel;
use App\Models\UsersModel;
use App\Notifications\NotificationsMailer;
use App\Enums\NotificationTypeEnum;
use App\Enums\NotificationStatusEnum;
use Exception;

final class NotificationsService {
    private NotificationsModel $model;
    private NotificationsMailer $mailer;
    private array $managers;
    
    /**
     * @throws Exception
     */
    public function __construct() {
        $this->model = new NotificationsModel();
        $this->mailer = new NotificationsMailer();
    }
    
    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getNotifications(array $filters): array {
        return $this->model->findAll($filters);
    }
    
    /**
     * @param int $id
     * @return Notification|null
     * @throws Exception
     */
    public function getNotification(int $id): ?Notification {
        return $this->model->findById($id);
    }
    
    /**
     * @param Registration $registration
     * @param bool $cancellation
     * @return void
     * @throws Exception
     */
    public function notify(Registration $registration, bool $cancellation = false): void {
        $this->setManagers();
        
        $notification = new Notification();
        $notification->setUserFk($registration->getUserFk());
        $notification->setJpoEventFk($registration->getJpoEventFk());
        
        if ($registration->getUserObject()->isManager()) {
            $this->managers = array_filter($this->getManagers(), fn(User $manager) => $manager->getId() != $registration->getUserFk());
        }
        
        $notification->setTypeFk($cancellation
            ? NotificationTypeEnum::Cancellation->value
            : NotificationTypeEnum::Confirmation->value
        );
        
        $sentResult = $cancellation
            ? $this->mailer->sendCancellationNotification($registration->getUserObject(), $registration->getJpoEventObject(), $this->getManagers())
            : $this->mailer->sendRegistrationNotification($registration->getUserObject(), $registration->getJpoEventObject(), $this->getManagers());
        
        $notification->setStatusFk($sentResult === true ? NotificationStatusEnum::Sent->value : NotificationStatusEnum::Failed->value);
        $this->model->save($notification);
    }
    
    /**
     * @return void
     * @throws Exception
     */
    private function setManagers(): void {
        $this->managers = (new UsersModel())->getManagers() ?? [];
    }
    private function getManagers(): array {
        return $this->managers;
    }
}

