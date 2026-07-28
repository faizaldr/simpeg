<?php
/**
 * Modul Payroll / Slip Gaji.
 * CWE-22 Path Traversal, CWE-352 CSRF, CWE-807 Reliance on Untrusted Input
 * (Critical), CWE-319 Cleartext Transmission (lihat app/Services/PayrollService.php).
 */

class PayrollController
{
    /**
     * CWE-22 Path Traversal: nama berkas dari $_GET dipakai LANGSUNG untuk
     * membaca berkas dari folder storage slip gaji, tanpa validasi apa pun.
     * Input `../../` dapat membawa proses baca keluar dari folder yang
     * dimaksud. (Catatan: berbeda dari SlipGaji::findFilePdfById() yang
     * dipakai versi TERPATCH — baseline di sini sengaja tidak query DB.)
     */
    public function download(): void
    {
        AuthMiddleware::handle();

        /*$file = $_GET['file'] ?? '';
        $path = __DIR__ . '/../../public/uploads/slip_gaji/' . $file; // --- CWE-22: tanpa basename()/realpath() ---

        if ($file !== '' && file_exists($path)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            readfile($path);
            exit;
        }

        http_response_code(404);
        echo 'Berkas tidak ditemukan.';
        */
        $idSlip = (int) ($_GET['id'] ?? 0);
        $stmt = Database::connection()->prepare('SELECT file_pdf FROM slip_gaji WHERE id =? AND id_karyawan = ?');
        $namaBerkas = $stmt->fetchColumn();
        if (!$namaBerkas) {
            http_response_code(404);
            exit('Berkas tidak ditemukan');
        }
        $folderStorage = realpath(__DIR__ . '/../uploads/slip_gaji');
        $path = realpath($folderStorage . '/' . basename($namaBerkas));
        if ($path === false || strpos($path, $folderStorage) !== 0) {
            http_response_code(404);
            exit("berkas tidak ditemukan");
        }
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        readfile($path);
        exit;
                
            }

    /**
     * CWE-352 Cross-Site Request Forgery (CSRF): form ubah rekening TIDAK
     * memiliki token apa pun — server langsung memproses $_POST.
     */
    public function updateRekening(): void
    {
        AuthMiddleware::handle();

        $idKaryawan = (int) ($_SESSION['id_karyawan'] ?? 1);
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- TAMBAHKAN VALIDASI CSRF ---
        if (!isset($_POST['csrf_token']) || !Csrf::isValid($_POST['csrf_token'])) {
            http_response_code(403);
            die('CSRF token validation failed');
        }
        // --- AKHIR TAMBAHAN ---
        
            $rekeningBaru = $_POST['no_rekening'] ?? '';
            Karyawan::updateNoRekening($idKaryawan, Crypto::encrypt($rekeningBaru));
            $message = 'Nomor rekening berhasil diubah.';
        }

        $pageTitle = 'Ubah Rekening Gaji';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/payroll/update_rekening.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    /**
     * CWE-807 Reliance on Untrusted Input in a Security Decision (Critical):
     * hak akses untuk memproses payroll ditentukan lewat Auth::currentRole(),
     * yang (lihat app/Helpers/Auth.php) MEMPERCAYA cookie `role` kiriman
     * klien bila ada — bukan hanya dari sesi server yang terverifikasi.
     */
    public function proses(): void
    {
        AuthMiddleware::handle();

        $message = null;

        // --- CWE-807: keputusan otorisasi memakai nilai yang bisa dipengaruhi klien ---
        if (Auth::currentRole() !== 'hrd') {
            http_response_code(403);
            $message = 'Hanya role HRD yang boleh memproses payroll.';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = PayrollService::prosesBulanIni();
        }

        $pageTitle = 'Proses Payroll';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/payroll/proses.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    public function kirimKeBank(): void
    {
        AuthMiddleware::handle();

        $berkasLokal = __DIR__ . '/../../public/uploads/slip_gaji/rekap_gaji_bulan_ini.csv';
        $message = PayrollService::kirimRekapKeBank($berkasLokal);

        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/payroll/kirim_ke_bank.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}