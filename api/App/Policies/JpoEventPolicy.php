<?php
namespace App\Policies;

use App\Entities\User;
use App\Entities\JpoEvent;

final class JpoEventPolicy {
    public static function canCreate(User $user, JpoEvent $jpoEvent): bool {
        return self::canManage($user, $jpoEvent);
    }
    
    public static function canUpdate(User $user, JpoEvent $jpoEvent): bool {
        return self::canManage($user, $jpoEvent);
    }
    
    public static function canDelete(User $user, JpoEvent $jpoEvent): bool {
        return self::canManage($user, $jpoEvent);
    }
    
    
    private static function canManage(User $user, JpoEvent $jpoEvent): bool {
        return $user->isDirector() || self::isLocaleManager($user, $jpoEvent);
    }
    
    private static function isLocaleManager(User $user, JpoEvent $jpoEvent): bool {
        return $user->isManager() && $user->getLocationFk() === $jpoEvent->getLocationFk();
    }
}