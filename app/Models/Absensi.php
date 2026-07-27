<?php
/**
 * Model tabel `absensi`.
 */

class Absensi
{
    public static function insert(int $idKaryawan, string $tanggal, string $jamMasuk, string $jamKeluar): void
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO absensi (id_karyawan, tanggal, jam_masuk, jam_keluar, sumber_import) VALUES (?,?,?,?,"xml")'
        );
        $stmt->execute([$idKaryawan, $tanggal, $jamMasuk, $jamKeluar]);
    }
}
