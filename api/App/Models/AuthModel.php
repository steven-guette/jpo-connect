<?php
namespace App\Models;

use App\Entities\User;
use App\Entities\Location;
use Core\Model\BaseModel;
use Exception;

final class AuthModel extends BaseModel {
    public function __construct() {
        parent::__construct('users', User::class);
    }
    
    /**
     * @param int $id
     * @return User|null
     * @throws Exception
     */
    public function getUserById(int $id): ?User {
        $sqlResult = $this->readOne(['id' => $id]);
        if (empty($sqlResult)) return null;
        
        $user = new User($sqlResult);
        $this->setUserLocation($user);
        return $user;
    }
    
    /**
     * @param string $email
     * @return User|null
     * @throws Exception
     */
    public function getUserByEmail(string $email): ?User {
        $sqlResult = $this->readOne(['email' => $email]);
        if (empty($sqlResult)) return null;
        
        $user = new User($sqlResult);
        $this->setUserLocation($user);
        return $user;
    }

    /**
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function refreshPassword(User $user): void {
        $this->update($user->getId(), ['password' => $user->getPassword()]);
    }
    
    /**
     * @param User $user
     * @return void
     * @throws Exception
     */
    private function setUserLocation(User $user): void {
        if ($locationId = $user->getLocationFk()) {
            $location = new Location((new LocationsModel())->findById($locationId));
            $user->setLocation($location);
        }
    }
}