<?php
namespace App\Policies;

use App\Entities\User;
use App\Entities\Registration;

final class RegistrationPolicy {
    public static function canCreate(User $user, Registration $registration): bool {
        return self::isSelf($user, $registration);
    }
    
    public static function canUpdate(User $user, Registration $registration): bool {
        return self::canManage($user, $registration);
    }
    
    public static function canDelete(User $user, Registration $registration): bool {
        return self::canManage($user, $registration);
    }
    
    
    private static function canManage(User $user, Registration $registration): bool {
        return $user->isDirector() || self::isSelf($user, $registration) || self::isLocalManager($user, $registration);
    }
    
    private static function isSelf(User $user, Registration $registration): bool {
        return $user->getId() === $registration->getUserFk();
    }
    
    private static function isLocalManager(User $user, Registration $registration): bool {
        return $user->isManager() && $user->getLocationFk() === $registration->getJpoEventObject()->getLocationFk();
    }
}