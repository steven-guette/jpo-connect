<?php
namespace App\Models;

use App\Entities\Registration;
use App\Entities\User;
use App\Entities\JpoEvent;
use Core\Model\CrudModel;
use DateTime;
use Exception;

final class RegistrationsModel extends CrudModel {
    public function __construct() {
        parent::__construct('registrations', Registration::class);
    }
    
    public function findById(int $id): ?Registration {
        $query = '
            SELECT r.*, u.name as users_name, u.firstname as users_firstname, u.created_at as users_created_at, u.role_id as users_role_id
            FROM registrations r
            INNER JOIN users u ON r.user_fk = u.id
            WHERE r.id = :registration_id
            ORDER BY users_role_id ASC;
        ';
        
        $this->sqlQuery($query, ['registration_id' => $id]);
        $sqlResult = $this->cursor->fetch();
        return $this->buildRegistrationObject($sqlResult);
    }
    
    public function findAll(array $filters): array {
        $query = '
            SELECT r.*, u.name as users_name, u.firstname as users_firstname, u.created_at as users_created_at, u.role_id as users_role_id
            FROM registrations r
            INNER JOIN users u ON r.user_fk = u.id
        ' . $this->buildClauses($filters) . ' ORDER BY users_role_id ASC;';
        
        $this->sqlQuery($query, $filters);
        $sqlResult = $this->cursor->fetchAll();
        return array_map(fn($item) => $this->buildRegistrationObject($item), $sqlResult);
    }
    
    /**
     * @param object $entity
     * @return ?Registration
     * @throws Exception
     */
    public function findRegistration(object $entity): ?Registration {
        $query = '
            SELECT * FROM registrations
            WHERE user_fk = :user AND jpo_event_fk = :event
            LIMIT 1;
        ';
        
        $this->sqlQuery($query, ['user' => $entity->getUserFk(), 'event' => $entity->getJpoEventFk()]);
        $sqlResult = $this->cursor->fetch();
        return $sqlResult ? new Registration($sqlResult) : null;
    }
    
    /**
     * @param Registration $registration
     * @param int $cooldown
     * @return bool
     * @throws Exception
     */
    public function wasRecentlyModified(Registration $registration, int $cooldown = 300): bool {
        $params = [
            'user' => $registration->getUserFk(),
            'event' => $registration->getJpoEventFk(),
            'limit_time' => (new DateTime())->modify("-$cooldown seconds")->format('Y-m-d H:i:s')
        ];
        
        $query = "
            SELECT id FROM registrations
            WHERE user_fk = :user AND jpo_event_fk = :event
            AND updated_at >= :limit_time;
        ";
        
        $this->sqlQuery($query, $params);
        return ($this->cursor->fetch() !== false);
    }
    
    /**
     * @param bool|array $sqlResult
     * @return Registration
     * @throws Exception
     */
    private function buildRegistrationObject(bool|array $sqlResult): Registration {
        if (empty($sqlResult)) {
            throw new Exception("Aucune réservation ne correspond à la recherche.");
        }
        
        $user = new User();
        $jpoEvent = new JpoEvent();
        
        $this->fastHydrate($sqlResult, $user, 'users');
        
        $registration = new Registration($sqlResult);
        $registration->setUser($user);
        $registration->setJpoEvent($jpoEvent);
        
        return $registration;
    }
}