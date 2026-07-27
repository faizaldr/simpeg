<?php
/**
 * Modul Ekspor Laporan.
 * CWE-799 Improper Control of Interaction Frequency: endpoint ekspor dapat
 * dipanggil BERULANG KALI tanpa batas oleh klien yang sama — tidak ada
 * rate limiting, penguncian sementara, maupun CAPTCHA.
 */

class LaporanController
{
    public function ekspor(): void
    {
        AuthMiddleware::handle();

        // --- CWE-799: TIDAK ADA pengecekan jumlah permintaan per akun/IP di sini ---

        $rows = Karyawan::all();

        if (isset($_GET['unduh'])) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="rekap_pegawai.csv"');
            $out = fopen('php://output', 'w');
            fputcsv($out, ['NIK', 'Nama']);
            foreach ($rows as $row) {
                fputcsv($out, [$row['nik'], $row['nama']]);
            }
            fclose($out);
            exit;
        }

        $pageTitle = 'Ekspor Laporan';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/laporan/ekspor.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}
