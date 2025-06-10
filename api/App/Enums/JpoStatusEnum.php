<?php
namespace App\Enums;

enum JpoStatusEnum: int {
    case Draft     = 1;
    case Published = 2;
    case Canceled  = 3;
    case Archived  = 4;
    
    public function label(): string {
        return match ($this) {
            self::Draft     => 'Brouillon',
            self::Published => 'Publié',
            self::Canceled  => 'Annulé',
            self::Archived  => 'Archivé',
        };
    }
}