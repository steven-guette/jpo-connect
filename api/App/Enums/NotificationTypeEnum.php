<?php
namespace App\Enums;

enum NotificationTypeEnum: int {
    case Confirmation = 1;
    case Cancellation = 2;
    
    public function label(): string {
        return match ($this) {
            self::Confirmation => 'Confirmation',
            self::Cancellation => 'Annulation'
        };
    }
}
