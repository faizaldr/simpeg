<?php
/**
 * Model tabel `pengaturan_sistem` — menyimpan konfigurasi dinamis,
 * termasuk rumus tunjangan (titik CWE-94, lihat app/Services/RumusTunjanganService.php).
 */

class PengaturanSistem
{
    public static function get(string $key, string $default = ''): string
    {
        $stmt = Database::connection()->prepare('SELECT `value` FROM pengaturan_sistem WHERE `key` = ?');
        $stmt->execute([$key]);

        return $stmt->fetchColumn() ?: $default;
    }

    public static function set(string $key, string $value): void
    {
        $stmt = Database::connection()->prepare(
            "INSERT INTO pengaturan_sistem (`key`, `value`) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)"
        );
        $stmt->execute([$key, $value]);
    }
}
