<?php
/**
 * Import absensi dari "mesin fingerprint" (berkas XML).
 *
 * CWE-611 XXE (XML External Entity): parser XML memakai LIBXML_NOENT tanpa
 * menonaktifkan pemuatan entitas eksternal — <!DOCTYPE ... SYSTEM "file://...">
 * di dalam XML kiriman pengguna benar-benar diproses.
 *
 * CWE-248 Uncaught Exception: parsing & insert dijalankan tanpa try/catch
 * sama sekali — berkas yang formatnya tidak sesuai membuat aplikasi berhenti
 * dan menampilkan stack trace lengkap (karena display_errors aktif, lihat
 * config/config.php).
 */

class AbsensiImportService
{
    public static function importDariBerkas(string $tmpPath): array
    {
        $isiXml = file_get_contents($tmpPath);

        // --- CWE-611: LIBXML_NOENT tanpa menonaktifkan entity loader ---
        $xml = simplexml_load_string($isiXml, 'SimpleXMLElement', LIBXML_NOENT);

        // --- CWE-248: TIDAK ADA try/catch di sekitar proses parsing/insert berikut ---
        foreach ($xml->record as $record) {
            // Baris berikut akan memicu TypeError tak tertangani bila elemen XML tidak lengkap/rusak.
            Absensi::insert(
                (int) $record->id_karyawan,
                (string) $record->tanggal,
                (string) $record->jam_masuk,
                (string) $record->jam_keluar
            );
        }

        return [
            'pesan' => 'Import selesai. Isi XML (untuk demo XXE) juga ditampilkan mentah di bawah:',
            'previewXxe' => (string) $xml->asXML(),
        ];
    }
}
