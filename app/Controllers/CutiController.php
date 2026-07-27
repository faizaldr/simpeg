<?php
/**
 * Modul Pengajuan & Persetujuan Cuti.
 * CWE-362 Race Condition (lihat app/Services/CutiService.php),
 * CWE-79 Stored XSS (catatan cuti), CWE-1021 Clickjacking (halaman setujui).
 */

class CutiController
{
    public function ajukan(): void
    {
        AuthMiddleware::handle();

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idKaryawan = (int) ($_SESSION['id_karyawan'] ?? 1);
            $jumlahHari = (int) ($_POST['jumlah_hari'] ?? 0);
            $catatan = $_POST['catatan'] ?? '';

            $message = CutiService::ajukan($idKaryawan, $jumlahHari, $catatan);
        }

        $pageTitle = 'Ajukan Cuti';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/cuti/ajukan.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    /**
     * CWE-79 Stored Cross-Site Scripting (XSS): kolom `catatan` yang ditulis
     * pegawai (lihat ajukan()) ditampilkan ulang ke SEMUA pengguna (termasuk
     * HRD) TANPA di-escape — lihat resources/views/pages/cuti/daftar.php.
     */
    public function daftar(): void
    {
        AuthMiddleware::handle();

        $rows = Cuti::all();

        $pageTitle = 'Daftar Pengajuan Cuti';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/cuti/daftar.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    /**
     * CWE-1021 Improper Restriction of Rendered UI Layers (Clickjacking):
     * halaman aksi kritis ini TIDAK mengirim header X-Frame-Options maupun
     * Content-Security-Policy: frame-ancestors — bisa dibingkai transparan
     * lewat <iframe> di situs lain dan diklik tanpa sadar oleh korban.
     */
    public function setujui(): void
    {
        AuthMiddleware::handle();

        // --- CWE-1021: TIDAK ADA header('X-Frame-Options: DENY') di sini ---

        $id = (int) ($_GET['id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Cuti::approve($id);
            header('Location: ' . APP_URL . '/cuti/daftar.php');
            exit;
        }

        $pageTitle = 'Setujui Pengajuan Cuti';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/cuti/setujui.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}
