<?php
namespace App\Enums;

enum RoleEnum: int {
    case Director   = 1;
    case Manager    = 2;
    case Employee   = 3;
    case Visitor    = 4;
    
    public function label(): string {
        return match ($this) {
            self::Director  => 'Directeur',
            self::Manager   => 'Responsable',
            self::Employee  => 'Employé',
            self::Visitor   => 'Visiteur',
        };
    }
}