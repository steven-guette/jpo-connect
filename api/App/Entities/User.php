<?php
namespace App\Entities;

use Core\Traits\ToDatabaseTrait;
use Exception;
use DateTime;
use Core\Entity;
use App\Enums\RoleEnum;

final class User extends Entity {
    use ToDatabaseTrait;
    private ?int $locationFk = null;
    
    private ?int $id = null;
    private int $roleId;
    private ?string $name = null;
    private ?string $firstname = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $socialProvider = null;
    private ?string $createdAt = null;
    
    private ?Location $location = null;
    private RoleEnum $role;
    
    private const DEFAULT_ROLE = RoleEnum::Visitor;
    
    
    public function __construct(array $data = []) {
        $this->setRoleId(self::DEFAULT_ROLE->value);
        
        parent::__construct($data);
        $this->setHidden(['password', 'role']);
        $this->setNonPersistedData(['created_at', 'location', 'role']);
    }
    
    public function toArray(): array {
        $initialArray = parent::toArray();
        $initialArray['fullName'] = $this->getFullName();
        $initialArray['roleName'] = $this->getRoleName();
        return $initialArray;
    }
    

    public function isDirector(): bool { return $this->getRole() === RoleEnum::Director; }
    public function isManager(): bool { return $this->getRole() === RoleEnum::Manager; }
    public function isEmployee(): bool { return $this->getRole() === RoleEnum::Employee; }
    public function isVisitor(): bool { return $this->getRole() === RoleEnum::Visitor; }
    
    public function getLocationObject(): ?Location { return $this->location; }
    
    /**
     * @return ?DateTime
     * @throws Exception
     */
    public function getCreatedAtObject(): ?DateTime {
        return $this->createdAt ? new DateTime($this->createdAt) : null;
    }
    
    public function getRoleName(): string { return $this->role->label(); }
    
    public function getFullName(): string { return $this->firstname . ' ' . $this->name; }

    public function clearPassword(): void { $this->password = null; }
    
    
    public function setLocationFk(int $locationFk): void { $this->locationFk = $locationFk; }
    public function getLocationFk(): ?int { return $this->locationFk; }
    
    public function setLocation(Location $location): void { $this->location = $location; }
    public function getLocation(): ?array { return $this->location->toArray() ?? null; }

    public function setId(int $id): void { $this->id = $id; }
    public function getId(): ?int { return $this->id; }
    
    public function setRoleId(int $roleId): void {
        $role = RoleEnum::tryFrom($roleId) ?? self::DEFAULT_ROLE;
        $this->roleId = $role->value;
        $this->setRole($role);
    }
    public function getRoleId(): ?int { return $this->roleId; }

    public function setRole(RoleEnum $role): void { $this->role = $role; }
    public function getRole(): RoleEnum { return $this->role; }
    
    public function setName(string $name): void { $this->name = ucfirst($name); }
    public function getName(): ?string { return $this->name; }
    
    public function setFirstname(string $firstname): void { $this->firstname = ucfirst($firstname); }
    public function getFirstname(): ?string { return $this->firstname; }
    
    public function setEmail(string $email): void { $this->email = $email; }
    public function getEmail(): ?string { return $this->email; }
    
    public function setPassword(string $password): void { $this->password = $password; }
    public function getPassword(): ?string { return $this->password; }
    
    public function setSocialProvider(string $socialProvider): void { $this->socialProvider = $socialProvider; }
    public function getSocialProvider(): ?string { return $this->socialProvider; }
    
    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
}