<?php
namespace App\Enums;

enum NotificationStatusEnum: int {
    case Sent       = 1;
    case Failed     = 2;
    
    public function label(): string {
        return match($this) {
            self::Sent => 'Envoyé',
            self::Failed => 'Échec'
        };
    }
}