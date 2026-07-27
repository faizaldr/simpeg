<?php
/**
 * Modul Dokumen Kepegawaian. Logika upload (CWE-434) & konversi (CWE-78)
 * ada di app/Services/DokumenService.php.
 */

class DokumenController
{
    public function upload(): void
    {
        AuthMiddleware::handle();

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['dokumen'])) {
            $hasil = DokumenService::unggah(
                $_FILES['dokumen']['tmp_name'],
                $_FILES['dokumen']['name'],
                $_POST['jenis'] ?? 'lainnya',
                $_SESSION['id_karyawan'] ?? 1
            );
            $message = $hasil['pesan'];
        }

        $pageTitle = 'Upload Dokumen';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/dokumen/upload.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    public function convert(): void
    {
        AuthMiddleware::handle();

        $output = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['dok'])) {
            $output = DokumenService::konversiKePdf($_FILES['dok']['tmp_name'], $_FILES['dok']['name']);
        }

        $pageTitle = 'Konversi Dokumen ke PDF';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/dokumen/convert.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}
