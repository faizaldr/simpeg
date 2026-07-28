<?php

/**
 * Model tabel `karyawan`. Lihat desain_dan_kebutuhan_aplilkasi.md §7.
 */

class Karyawan
{
    public static function findById(int $id): array|false
    {
        $stmt = Database::connection()->prepare('SELECT * FROM karyawan WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public static function all(): array
    {
        $stmt = Database::connection()->query('SELECT nik, nama FROM karyawan');

        return $stmt->fetchAll();
    }

    /**
     * CWE-639 IDOR / Authorization Bypass via User-Controlled Key: method ini
     * sengaja MENERIMA $id dari mana pun tanpa memverifikasi kepemilikan —
     * lihat KaryawanController::profil() yang memanggilnya dengan id dari
     * hidden input form, bukan dari sesi.
     */
    public static function updateNama(int $id, string $nama): void
    {
        $stmt = Database::connection()->prepare('UPDATE karyawan SET nama = ? WHERE id = ?');
        $stmt->execute([$nama, $id]);
    }

    public static function updateNoRekening(int $id, string $noRekeningTerenkripsi): void
    {
        $stmt = Database::connection()->prepare('UPDATE karyawan SET no_rekening = ? WHERE id = ?');
        $stmt->execute([$noRekeningTerenkripsi, $id]);
    }

    public static function updateFotoUrl(int $idUser, string $url): void
    {
        $stmt = Database::connection()->prepare('UPDATE karyawan SET foto_url = ? WHERE id_user = ?');
        $stmt->execute([$url, $idUser]);
    }

    /**
     * CWE-862 Missing Authorization: method ini TIDAK melakukan pengecekan
     * hak akses apa pun — itu memang sengaja bukan tugas Model. Yang membuat
     * CWE-862 nyata adalah KaryawanController::hapus() memanggil method ini
     * TANPA middleware auth/role apa pun.
     */
    public static function delete(int $id): void
    {
        $stmt = Database::connection()->prepare('DELETE FROM karyawan WHERE id = ?');
        $stmt->execute([$id]);
    }

    /**
     * CWE-89 SQL Injection: titik injeksi KEDUA pada SIMPEG — keyword
     * pencarian digabung langsung ke query, tanpa parameter terikat.
     */
    public static function searchByNamaRaw(string $keyword): array
    {
        // $sql = "SELECT id, nik, nama FROM karyawan WHERE nama LIKE '%$keyword%'";
        // $stmt = Database::rawQuery($sql);

        $stmt = Database::connection()->prepare(
            'SELECT id, nik, nama
         FROM karyawan
         WHERE nama LIKE ?'
        );

        $stmt->execute(["%{$keyword}%"]);

        return $stmt ? $stmt->fetchAll() : [];
    }
}
