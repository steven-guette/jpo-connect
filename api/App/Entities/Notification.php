<?php
namespace App\Entities;

use Core\Traits\ToDatabaseTrait;
use Core\Entity;
use DateTime;
use Exception;

final class Notification extends Entity {
    use ToDatabaseTrait;
    
    private int $userFk;
    private int $jpoEventFk;
    private int $typeFk;
    private int $statusFk;
    
    private ?int $id = null;
    private ?string $sentAt = null;
    
    
    public function __construct(array $data = []) {
        parent::__construct($data);
    }
    
    
    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getSentAtObject(): ?DateTime { return $this->sentAt ? new DateTime($this->sentAt) : null; }
    
    
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    
    public function getSentAt(): ?string { return $this->sentAt; }
    public function setSentAt(string $sentAt): void { $this->sentAt = $sentAt; }
    
    public function getUserFk(): int { return $this->userFk; }
    public function setUserFk(int $userFk): void { $this->userFk = $userFk; }
    
    public function getJpoEventFk(): int { return $this->jpoEventFk; }
    public function setJpoEventFk(int $jpoEventFk): void { $this->jpoEventFk = $jpoEventFk; }
    
    public function getTypeFk(): int { return $this->typeFk; }
    public function setTypeFk(int $typeFk): void { $this->typeFk = $typeFk; }
    
    public function getStatusFk(): int { return $this->statusFk; }
    public function setStatusFk(int $statusFk): void { $this->statusFk = $statusFk; }
}