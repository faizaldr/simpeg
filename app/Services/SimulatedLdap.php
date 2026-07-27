<?php
/**
 * Direktori LDAP TIRUAN untuk lab (tidak perlu server LDAP sungguhan).
 * Meniru pola pencarian filter LDAP yang rentan (CWE-90), termasuk
 * kelemahannya: filter dibentuk dari string kiriman pengguna tanpa escaping,
 * dan pencocokan wildcard `*` diterima apa adanya oleh "server" tiruan ini.
 */

class SimulatedLdap
{
    private static function directory(): array
    {
        return [
            ['uid' => 'andi.wijaya', 'cn' => 'Andi Wijaya', 'role' => 'staf', 'password' => 'RahasiaAndi1!'],
            ['uid' => 'budi.santoso', 'cn' => 'Budi Santoso', 'role' => 'staf', 'password' => 'RahasiaBudi1!'],
            ['uid' => 'citra.lestari', 'cn' => 'Citra Lestari', 'role' => 'hrd', 'password' => 'RahasiaCitra1!'],
        ];
    }

    /**
     * Dipakai pada KODE HASIL PATCH (lihat langkah_pengujian_kerentanan_dan_patching.md,
     * CWE-90): mensimulasikan operasi bind LDAP sungguhan — kata sandi WAJIB
     * cocok, bukan sekadar filter uid yang cocok.
     */
    public static function bind(string $uid, string $password): bool
    {
        foreach (self::directory() as $entry) {
            if ($entry['uid'] === $uid) {
                return hash_equals($entry['password'], $password);
            }
        }

        return false;
    }

    /**
     * CWE-90 LDAP Injection: menerima filter yang SUDAH dibentuk lewat
     * konkatenasi string oleh pemanggil (lihat public/auth/sso_login.php),
     * lalu mengevaluasi pola `uid=...` dengan fnmatch() — sehingga nilai
     * wildcard (`*`) pada input pengguna ikut dievaluasi sebagai wildcard,
     * bukan sebagai teks literal yang harus di-escape lebih dulu.
     */
    public static function search(string $rawFilter): ?array
    {
        if (!preg_match('/uid=([^)]*)/', $rawFilter, $m)) {
            return null;
        }

        $pattern = $m[1];

        foreach (self::directory() as $entry) {
            if (fnmatch($pattern, $entry['uid'])) {
                return $entry;
            }
        }

        return null;
    }
}
