<?php
/**
 * Model tabel `slip_gaji`.
 *
 * CWE-22 Path Traversal: nama berkas asalnya dari kolom `file_pdf` yang
 * dikembalikan method di bawah ini. Titik kerentanan sesungguhnya ada di
 * PayrollController::download() yang (pada baseline) memakai nama berkas
 * dari $_GET, bukan hasil query ini — lihat catatan CWE-22 di sana.
 */

class SlipGaji
{
    public static function findFilePdfById(int $id): string|false
    {
        $stmt = Database::connection()->prepare('SELECT file_pdf FROM slip_gaji WHERE id = ? AND id_karyawan = ?');
        $stmt->execute([$id, $_SESSION['id_karyawan'] ?? 0]);

        return $stmt->fetchColumn();
    }
}
