<?php
namespace App\Models;

use App\Entities\Location;
use App\Entities\User;
use App\Enums\RoleEnum;
use Core\Model\CrudModel;
use Core\Exceptions\ValidationException;
use Exception;

final class UsersModel extends CrudModel {
    public function __construct() {
        parent::__construct('users', User::class);
    }
    
    public function findById(int $id): ?User {
        $query = '
            SELECT u.id, u.name, u.firstname, u.email, u.role_id, u.created_at, u.social_provider, u.location_fk,
                   l.id as locations_id, l.city as locations_city, l.street_number as locations_street_number,
                   l.street_name as locations_street_name, l.zip_code as locations_zip_code, l.gps_coordinates as locations_gps_coordinates
            FROM users u
            LEFT JOIN locations l ON u.location_fk = l.id
            WHERE u.id = :user_id;
        ';
        
        $this->sqlQuery($query, ['user_id' => $id]);
        $sqlResult = $this->cursor->fetch();
        return $this->buildUserObject($sqlResult);
    }
    
    public function findAll(array $filters): array {
        $query = '
            SELECT u.id, u.name, u.firstname, u.email, u.role_id, u.created_at, u.social_provider, u.location_fk,
                   l.id as locations_id, l.city as locations_city, l.street_number as locations_street_number,
                   l.street_name as locations_street_name, l.zip_code as locations_zip_code, l.gps_coordinates as locations_gps_coordinates
            FROM users u
            LEFT JOIN locations l ON u.location_fk = l.id
        ' . $this->buildClauses($filters) . ';';
        
        $this->sqlQuery($query, $filters);
        $sqlResult = $this->cursor->fetchAll();
        return array_map(fn($item) => $this->buildUserObject($item), $sqlResult);
    }

    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getPublicList(array $filters): array {
        $sqlResult = $this->readAll($filters, ['id', 'name', 'firstname', 'role_id', 'created_at', 'location_fk']);
        return $this->mapEntities($sqlResult);
    }
    
    /**
     * @return array
     * @throws Exception
     */
    public function getManagers(): array {
        $sqlResult = $this->readAll(['role_id' => RoleEnum::Manager->value], ['id', 'name', 'firstname', 'email', 'location_fk']);
        return $this->mapEntities($sqlResult);
    }
    
    /**
     * @param string $email
     * @return bool
     * @throws Exception
     */
    public function emailAlreadyExists(string $email): bool {
        return !empty($this->readOne(['email' => $email]));
    }
    
    /**
     * @param bool|array $sqlResult
     * @return User
     * @throws Exception
     */
    private function buildUserObject(bool|array $sqlResult): User {
        if (empty($sqlResult)) {
            throw new Exception("Aucun utilisateur ne correspond à la recherche.");
        }
        
        $location = new Location();
        $this->fastHydrate($sqlResult, $location, 'locations');
        
        $user = new User($sqlResult);
        $user->setLocation($location);
        
        return $user;
    }
}