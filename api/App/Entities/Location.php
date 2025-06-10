<?php
namespace App\Entities;

use Core\Traits\ToDatabaseTrait;
use Core\Entity;

final class Location extends Entity {
    use ToDatabaseTrait;
    
    private ?int $id = null;
    private ?int $streetNumber = null;
    private ?string $streetName = null;
    private ?string $city = null;
    private ?string $zipCode = null;
    private ?string $gpsCoordinates = null;

    public function __construct(array $data = []) {
        parent::__construct($data);
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getStreetNumber(): ?int { return $this->streetNumber; }
    public function setStreetNumber(int $streetNumber): void { $this->streetNumber = $streetNumber; }

    public function getCity(): ?string { return $this->city; }
    public function setCity(string $city): void { $this->city = $city; }

    public function getStreetName(): ?string { return $this->streetName; }
    public function setStreetName(string $streetName): void { $this->streetName = $streetName; }

    public function getZipCode(): ?string { return $this->zipCode; }
    public function setZipCode(string $zipCode): void { $this->zipCode = $zipCode; }

    public function getGpsCoordinates(): ?string { return $this->gpsCoordinates; }
    public function setGpsCoordinates(string $gpsCoordinates): void { $this->gpsCoordinates = $gpsCoordinates; }
}