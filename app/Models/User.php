<?php
/**
 * Model tabel `user`. Lihat desain_dan_kebutuhan_aplilkasi.md §7.
 */

class User
{
    /**
     * CWE-89 SQL Injection: query dibentuk lewat konkatenasi string,
     * SENGAJA tidak memakai parameter terikat — lihat baris pemanggilnya
     * di AuthController::login().
     */
    public static function findByUsernameRaw(string $username): array|false
    {
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $stmt = Database::rawQuery($sql);

        return $stmt ? $stmt->fetch() : false;
    }

    public static function findById(int $id): array|false
    {
        $stmt = Database::connection()->prepare('SELECT * FROM user WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public static function updatePassword(int $id, string $hash): void
    {
        $stmt = Database::connection()->prepare('UPDATE user SET password = ? WHERE id = ?');
        $stmt->execute([$hash, $id]);
    }
}
