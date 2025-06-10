<?php
namespace App\Policies;

use App\Entities\User;

final class LocationPolicy {
    public static function canCreate(User $user): bool {
        return $user->isDirector();
    }

    public static function canUpdate(User $user): bool {
        return $user->isDirector();
    }

    public static function canDelete(User $user): bool {
        return $user->isDirector();
    }
}