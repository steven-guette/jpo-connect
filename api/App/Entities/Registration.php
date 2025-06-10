<?php
namespace App\Entities;

use Core\Traits\ToDatabaseTrait;
use Core\Entity;
use DateTime;
use Exception;

final class Registration extends Entity {
    use ToDatabaseTrait;
    
    private ?int $userFk = null;
    private ?int $jpoEventFk = null;
    
    private ?int $id = null;
    private bool $canceled = false;
    private bool $wasPresent = true;
    private string $updatedAt;
    
    private ?User $user = null;
    private ?JpoEvent $jpoEvent = null;
    
    
    public function __construct(array $data = []) {
        $this->updatedAt = date('Y-m-d H:i:s');
        $this->setNonPersistedData(['user', 'jpo_event']);
        parent::__construct($data);
    }
    
    
    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getUpdatedAtObject(): ?DateTime { return $this->updatedAt ? new DateTime($this->updatedAt) : null; }
    
    public function getUserObject(): ?User { return $this->user; }
    
    public function getJpoEventObject(): ?JpoEvent { return $this->jpoEvent; }
    
    
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    
    public function getCanceled(): bool { return $this->canceled; }
    public function setCanceled(bool $canceled): void { $this->canceled = $canceled; }
    
    public function getWasPresent(): bool { return $this->wasPresent; }
    public function setWasPresent(bool $wasPresent): void { $this->wasPresent = $wasPresent; }
    
    public function getUpdatedAt(): ?string { return $this->updatedAt; }
    public function setUpdatedAt(string $updatedAt): void { $this->updatedAt = $updatedAt; }
    
    public function getUserFk(): ?int { return $this->userFk; }
    public function setUserFk(int $userFk): void { $this->userFk = $userFk; }
    
    public function getJpoEventFk(): ?int { return $this->jpoEventFk; }
    public function setJpoEventFk(int $jpoEventFk): void { $this->jpoEventFk = $jpoEventFk; }
    
    public function getUser(): ?array { return $this->user->toArray() ?? null; }
    public function setUser(User $user): void { $this->user = $user; }
    
    /**
     * @return array|null
     * @throws Exception
     */
    public function getJpoEvent(): ?array { return $this->jpoEvent->toArray() ?? null; }
    public function setJpoEvent(JpoEvent $jpoEvent): void { $this->jpoEvent = $jpoEvent; }
}