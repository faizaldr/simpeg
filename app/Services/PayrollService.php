<?php
/**
 * Layanan pemrosesan payroll & pengiriman rekap gaji ke bank.
 */

class PayrollService
{
    /**
     * Simulasi pemrosesan payroll bulanan. Otorisasi (CWE-807) diperiksa di
     * PayrollController::proses() lewat Auth::currentRole() — lihat catatan
     * pada app/Helpers/Auth.php tentang kenapa itu SENGAJA rentan.
     */
    public static function prosesBulanIni(): string
    {
        return 'Payroll bulan ini berhasil diproses (simulasi).';
    }

    /**
     * CWE-319 Cleartext Transmission of Sensitive Information: berkas rekap
     * gaji dikirim ke host mitra bank lewat FTP POLOS (ftp_put), tanpa
     * enkripsi kanal sama sekali. Siapa pun yang menyadap jaringan bisa
     * membaca isinya dalam bentuk teks jelas.
     *
     * Catatan lab: host FTP di bawah adalah PLACEHOLDER (tidak benar-benar
     * terhubung) — tujuan method ini murni menunjukkan pola kode yang salah,
     * konsisten dengan kolom "Kode Rentan" pada checklist.
     */
    public static function kirimRekapKeBank(string $berkasLokal): string
    {
        $hostMitraBank = 'ftp.mitra-bank.internal.test'; // placeholder lab

        if (!file_exists($berkasLokal)) {
            return 'Berkas belum ada untuk didemokan (buat dulu berkas rekap, lalu jalankan ulang).';
        }

        // --- CWE-319: koneksi FTP polos, bukan FTPS/SFTP ---
        $koneksi = @ftp_connect($hostMitraBank);
        if ($koneksi) {
            @ftp_login($koneksi, 'simpeg', 'rahasia123');
            @ftp_put($koneksi, basename($berkasLokal), $berkasLokal, FTP_ASCII);
            ftp_close($koneksi);
        }

        return "Percobaan pengiriman berkas ke $hostMitraBank lewat FTP polos telah dijalankan.";
    }
}
