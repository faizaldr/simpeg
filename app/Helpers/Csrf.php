<?php
/**
 * Helper token CSRF — dipakai pada KODE HASIL PATCH (lihat
 * langkah_pengujian_kerentanan_dan_patching.md, CWE-352 & CWE-862).
 * Baseline SENGAJA tidak memanggil helper ini di form mana pun.
 */

class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            // CSPRNG (bukan uniqid()/mt_rand() seperti Auth::generateToken()) — lihat CWE-338.
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::token()) . '">';
    }

    public static function isValid(?string $token): bool
    {
        return $token !== null
            && !empty($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}
