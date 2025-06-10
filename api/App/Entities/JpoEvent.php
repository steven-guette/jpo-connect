<?php
namespace App\Entities;

use App\Enums\JpoStatusEnum;
use Core\Traits\ToDatabaseTrait;
use Core\Entity;
use DateTime;
use Exception;

final class JpoEvent extends Entity {
    use ToDatabaseTrait;
    
    private ?int $statusFk = null;
    private ?int $locationFk = null;
    
    private ?int $id = null;
    private int $currentRegistered = 0;
    private ?int $maxCapacity = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $practicalInfo = null;
    private ?string $imagePath = null;
    private ?string $startDatetime = null;
    private ?string $endDatetime = null;
    
    private ?Location $location = null;
    private JpoStatusEnum $status;
    
    public const DEFAULT_STATUS = JpoStatusEnum::Draft;
    
    
    public function __construct(array $data = []) {
        $this->setStatusFk(self::DEFAULT_STATUS->value);
        
        parent::__construct($data);
        $this->setHidden(['status']);
        $this->setNonPersistedData(['status', 'location']);
    }
    
    /**
     * @return array
     * @throws Exception
     */
    public function toArray(): array {
        $initialArray = parent::toArray();
        $initialArray['statusLabel'] = $this->getStatusLabel();
        $initialArray['duration'] = $this->getDuration();
        return $initialArray;
    }
    
    
    public function isDraft(): bool { return $this->getStatus() === JpoStatusEnum::Draft; }
    public function isPublished(): bool { return $this->getStatus() === JpoStatusEnum::Published; }
    public function isCanceled(): bool { return $this->getStatus() === JpoStatusEnum::Canceled; }
    public function isArchived(): bool { return $this->getStatus() === JpoStatusEnum::Archived; }
    
    public function getStatusLabel(): string { return $this->getStatus()->label() ?? ''; }
    
    public function getLocationObject(): ?Location { return $this->location; }
    
    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getStartDatetimeObject(): ?DateTime {
        return $this->startDatetime ? new DateTime($this->startDatetime) : null;
    }
    
    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function getEndDatetimeObject(): ?DateTime {
        return $this->endDatetime ? new DateTime($this->endDatetime) : null;
    }
    
    /**
     * @return string|null
     * @throws Exception
     */
    public function getDuration(): ?string {
        $startDatetime = $this->getStartDatetimeObject();
        $endDatetime = $this->getEndDatetimeObject();
        
        if (!$startDatetime || !$endDatetime) return null;
        
        $duration = $endDatetime->diff($startDatetime);
        return $duration->format('%a jours %h heures %i minutes');
    }
    
    
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    
    public function getMaxCapacity(): ?int { return $this->maxCapacity; }
    public function setMaxCapacity(int $maxCapacity): void { $this->maxCapacity = $maxCapacity; }
    
    public function getCurrentRegistered(): ?int { return $this->currentRegistered; }
    public function setCurrentRegistered(int $currentRegistered): void { $this->currentRegistered = $currentRegistered; }
    
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): void { $this->title = $title; }
    
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }
    
    public function getPracticalInfo(): ?string { return $this->practicalInfo; }
    public function setPracticalInfo(string $practicalInfo): void { $this->practicalInfo = $practicalInfo; }
    
    public function getImagePath(): ?string { return $this->imagePath; }
    public function setImagePath(string $imagePath): void { $this->imagePath = $imagePath; }
    
    public function getStartDatetime(): ?string { return $this->startDatetime; }
    public function setStartDatetime(string $startDatetime): void { $this->startDatetime = $startDatetime; }
    
    public function getEndDatetime(): ?string { return $this->endDatetime; }
    public function setEndDatetime(string $endDatetime): void { $this->endDatetime = $endDatetime; }
    
    public function getLocationFk(): ?int { return $this->locationFk; }
    public function setLocationFk(int $locationFk): void { $this->locationFk = $locationFk; }
    
    public function setLocation(Location $location): void { $this->location = $location; }
    public function getLocation(): ?array { return $this->location->toArray() ?? null; }
    
    public function getStatusFk(): ?int { return $this->statusFk; }
    public function setStatusFk(int $statusFk): void {
        $status = JpoStatusEnum::tryFrom($statusFk) ?? self::DEFAULT_STATUS;
        $this->statusFk = $status->value;
        $this->setStatus($status);
    }
    
    public function getStatus(): JpoStatusEnum { return $this->status; }
    public function setStatus(JpoStatusEnum $status): void { $this->status = $status; }
    
}