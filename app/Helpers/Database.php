<?php
/**
 * Koneksi database bersama (PDO). Query pada tiap modul TIDAK selalu
 * memakai prepared statement — sebagian sengaja dibuat rentan (lihat CWE-89).
 */

class Database
{
    private static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE . ';charset=utf8mb4';
            self::$instance = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$instance;
    }

    /**
     * CWE-89 SQL Injection: helper ini SENGAJA menjalankan query mentah
     * tanpa parameter terikat, dipakai oleh modul login & pencarian pegawai
     * untuk mendemonstrasikan injeksi. JANGAN dipakai di modul lain.
     */
    public static function rawQuery(string $sql): PDOStatement|false
    {
        return self::connection()->query($sql);
    }
}
