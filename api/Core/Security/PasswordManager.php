<?php
namespace Core\Security;

final class PasswordManager {
    private const ALGO = PASSWORD_BCRYPT;
    
    public static function hash(string $password): string {
        return password_hash($password, self::ALGO);
    }
    
    public static function verify(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
    
    public static function needsRehash(string $hash): bool {
        return password_needs_rehash($hash, self::ALGO);
    }
}