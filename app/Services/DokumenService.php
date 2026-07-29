<?php

/**
 * Layanan unggah & konversi dokumen kepegawaian.
 */

class DokumenService
{
    /**
     * CWE-434 Unrestricted File Upload: validasi HANYA memeriksa ekstensi
     * dari nama berkas kiriman klien (mudah dipalsukan), lalu menyimpannya
     * langsung di dalam public/uploads/dokumen — folder yang bisa diakses
     * & dieksekusi langsung lewat URL.
     */
    public static function unggah(string $tmpPath, string $namaAsli, string $jenis, int $idKaryawan): array
    {
        // --- CWE-434: validasi hanya dari EKSTENSI nama berkas kiriman klien ---
        $extBolehDiterima = ['jpg', 'jpeg', 'png', 'pdf'];
        $ext = strtolower(pathinfo($namaAsli, PATHINFO_EXTENSION));

        if (!in_array($ext, $extBolehDiterima, true)) {
            return ['sukses' => false, 'pesan' => 'Ekstensi berkas tidak diizinkan.'];
        }

        $tujuan = __DIR__ . '/../../public/uploads/dokumen/' . $namaAsli; // nama asli dipakai apa adanya
        move_uploaded_file($tmpPath, $tujuan);

        Dokumen::insert($idKaryawan, $jenis, 'uploads/dokumen/' . $namaAsli);

        return [
            'sukses' => true,
            'pesan' => "Berkas '$namaAsli' berhasil diunggah dan bisa diakses langsung di /uploads/dokumen/$namaAsli",
        ];
    }

    /**
     * CWE-78 OS Command Injection: nama berkas hasil upload digabung LANGSUNG
     * ke dalam string perintah shell yang dijalankan exec() — karakter shell
     * (`;`, `|`, dst.) pada nama berkas bisa menambahkan perintah baru.
     */
    public static function konversiKePdf(string $tmpPath, string $namaAsli): string
    {
        $tujuan = __DIR__ . '/../../public/uploads/dokumen/' . $namaAsli;
        move_uploaded_file($tmpPath, $tujuan);

        $soffice = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';

        // --- CWE-78: nama berkas (dari input pengguna) digabung langsung ke perintah shell ---
        $perintah = $soffice . ' --headless --convert-to pdf ' . escapeshellarg($tujuan) . ' 2>&1';
        exec($perintah, $hasilBaris);

        return implode("\n", $hasilBaris);
    }
}
