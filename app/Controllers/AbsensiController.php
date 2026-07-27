<?php
/**
 * Modul Import Absensi. Logika parsing XML (CWE-611 XXE, CWE-248 Uncaught
 * Exception) ada di app/Services/AbsensiImportService.php.
 */

class AbsensiController
{
    public function import(): void
    {
        AuthMiddleware::handle();

        $hasil = null;
        $previewXxe = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['berkas_xml'])) {
            $data = AbsensiImportService::importDariBerkas($_FILES['berkas_xml']['tmp_name']);
            $hasil = $data['pesan'];
            $previewXxe = $data['previewXxe'];
        }

        $pageTitle = 'Import Absensi';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/absensi/import.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}
