<?php
namespace App\Policies;

use App\Entities\User;

final class UserPolicy {
    public static function canRead(User $authUser, ?User $targetUser): bool {
        return self::canManage($authUser, $targetUser);
    }

    public static function canCreate(?User $user): bool {
        return !$user || $user->isDirector();
    }
    
    public static function canUpdate(User $authUser, User $targetUser): bool {
        return self::canManage($authUser, $targetUser);
    }
    
    public static function canDelete(User $authUser, User $targetUser): bool {
        return self::canManage($authUser, $targetUser);
    }
    
    
    private static function canManage(User $authUser, ?User $targetUser): bool {
        return $authUser->isDirector() || self::isSelf($authUser, $targetUser);
    }
    
    private static function isSelf(User $authUser, ?User $targetUser): bool {
        return $targetUser && $authUser->getId() === $targetUser->getId();
    }
}