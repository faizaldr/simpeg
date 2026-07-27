<?php
/**
 * CWE-362 Race Condition: saldo cuti dibaca, diperiksa, lalu ditulis sebagai
 * TIGA langkah terpisah tanpa transaksi/penguncian baris. Banyak permintaan
 * yang datang nyaris bersamaan bisa sama-sama lolos pemeriksaan sebelum
 * saldo sempat diperbarui.
 */

class CutiService
{
    private const JATAH_TAHUNAN = 12;

    public static function ajukan(int $idKaryawan, int $jumlahHari, string $catatan): string
    {
        // Langkah 1: BACA saldo
        $terpakai = Cuti::sumSaldoTerpakai($idKaryawan);
        $sisaSaldo = self::JATAH_TAHUNAN - $terpakai;

        // (jeda sengaja tidak ada penguncian — bandingkan dengan versi terpatch di tutorial)

        // Langkah 2: PERIKSA kecukupan
        if ($jumlahHari > 0 && $jumlahHari <= $sisaSaldo) {
            // Langkah 3: TULIS pengajuan baru — tanpa transaksi/SELECT ... FOR UPDATE
            Cuti::insert($idKaryawan, $jumlahHari, $catatan);

            return "Pengajuan $jumlahHari hari berhasil disetujui otomatis (sisa saldo saat cek: $sisaSaldo).";
        }

        return "Pengajuan ditolak, saldo tidak cukup (sisa: $sisaSaldo).";
    }
}
