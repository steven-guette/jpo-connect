<?php
namespace App\Policies;

use App\Entities\User;
use App\Entities\Comment;

final class CommentPolicy {
    public static function canCreate(bool $isLogged): bool {
        return $isLogged;
    }
    
    public static function canUpdate(User $user, Comment $comment): bool {
        return self::isSelf($user, $comment) || self::isLocalStaff($user, $comment);
    }
    
    public static function canDelete(User $user): bool {
        return $user->isDirector();
    }
    
    private static function isSelf(User $user, Comment $comment): bool {
        return $user->getId() === $comment->getUserFk();
    }
    
    private static function isLocalStaff(User $user, Comment $comment): bool {
        return ($user->isManager() || $user->isEmployee()) && $user->getLocationFk() === $comment->getLocationId();
    }
}