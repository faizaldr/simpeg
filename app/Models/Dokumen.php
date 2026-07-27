<?php
/**
 * Model tabel `dokumen`.
 */

class Dokumen
{
    public static function insert(int $idKaryawan, string $jenis, string $pathFile): void
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO dokumen (id_karyawan, jenis, path_file, uploaded_at) VALUES (?,?,?,NOW())'
        );
        $stmt->execute([$idKaryawan, $jenis, $pathFile]);
    }
}
