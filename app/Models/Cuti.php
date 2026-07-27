<?php
/**
 * Model tabel `cuti`. Logika pengajuan (rawan CWE-362 Race Condition)
 * sengaja ditaruh di app/Services/CutiService.php, bukan di sini — Model
 * hanya menyediakan operasi baca/tulis dasar.
 */

class Cuti
{
    public static function sumSaldoTerpakai(int $idKaryawan): int
    {
        $stmt = Database::connection()->prepare(
            'SELECT COALESCE(SUM(saldo_dipakai),0) AS terpakai FROM cuti WHERE id_karyawan = ? AND status = "disetujui"'
        );
        $stmt->execute([$idKaryawan]);

        return (int) $stmt->fetchColumn();
    }

    public static function insert(int $idKaryawan, int $jumlahHari, string $catatan): void
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO cuti (id_karyawan, tanggal_mulai, tanggal_selesai, saldo_dipakai, status, catatan)
             VALUES (?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL ? DAY), ?, "disetujui", ?)'
        );
        $stmt->execute([$idKaryawan, $jumlahHari, $jumlahHari, $catatan]);
    }

    public static function all(): array
    {
        $stmt = Database::connection()->query(
            'SELECT c.*, k.nama FROM cuti c JOIN karyawan k ON k.id = c.id_karyawan ORDER BY c.id DESC'
        );

        return $stmt->fetchAll();
    }

    public static function approve(int $id): void
    {
        $stmt = Database::connection()->prepare('UPDATE cuti SET status = "disetujui" WHERE id = ?');
        $stmt->execute([$id]);
    }
}
