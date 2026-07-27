<?php
/**
 * Helper autentikasi & sesi. Beberapa fungsi di sini SENGAJA lemah — dipakai
 * untuk mendemonstrasikan CWE-328, CWE-916, CWE-338, CWE-807 (lihat komentar
 * masing-masing fungsi dan desain_dan_kebutuhan_aplilkasi.md §9).
 */

class Auth
{
    /** CWE-328 Reversible One-Way Hash: MD5 polos tanpa salt. */
    public static function hashPassword(string $plain): string
    {
        return md5($plain);
    }

    public static function verifyPassword(string $plain, string $hash): bool
    {
        return md5($plain) === $hash;
    }

    /**
     * CWE-916 Insufficient Password Hash Effort: cost bcrypt sengaja
     * diturunkan drastis. Dipakai HANYA untuk demo perbandingan kecepatan
     * brute force pada sesi CWE-916, bukan untuk password login utama.
     */
    public static function hashServiceCredential(string $plain): string
    {
        return password_hash($plain, PASSWORD_BCRYPT, ['cost' => 4]);
    }

    /**
     * CWE-338 Cryptographically Weak PRNG: dipakai untuk token "ingat saya".
     * uniqid() berbasis waktu mikro sistem, bukan CSPRNG.
     */
    public static function generateToken(): string
    {
        return uniqid('simpeg_', true);
    }

    public static function login(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        // CWE-384 Session Fixation: TIDAK ADA session_regenerate_id(true) di sini.
    }

    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * CWE-807 Reliance on Untrusted Input in Security Decision (Critical):
     * bila cookie `role` dikirim klien, nilainya DIPERCAYA menimpa role sesi.
     * Sengaja begitu — dipakai modul Payroll untuk demo kerentanan Critical.
     */
    public static function currentRole(): ?string
    {
        if (isset($_COOKIE['role'])) {
            return $_COOKIE['role'];
        }

        return $_SESSION['role'] ?? null;
    }

    /**
     * CWE-521 Weak Password Requirements: hanya memeriksa panjang minimal 4.
     */
    public static function isPasswordAcceptable(string $plain): bool
    {
        return strlen($plain) >= 4;
    }
}
