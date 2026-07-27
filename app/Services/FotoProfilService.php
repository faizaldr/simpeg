<?php
/**
 * CWE-918 Server-Side Request Forgery (SSRF): mengambil isi URL kiriman
 * pengguna (file_get_contents) tanpa validasi tujuan sama sekali, lalu
 * menyimpannya sebagai "foto profil". Server bisa dipaksa mengunjungi
 * alamat internal/rahasia (mis. metadata service, jaringan privat).
 */

class FotoProfilService
{
    public static function ambilDariUrl(string $url, int $idUser): array
    {
        // --- CWE-918: tidak ada whitelist domain, tidak ada penolakan alamat privat/loopback ---
        $isi = @file_get_contents($url);

        if ($isi === false) {
            return ['sukses' => false, 'pesan' => 'Gagal mengambil konten dari URL tersebut.'];
        }

        $namaBerkas = 'foto_' . $idUser . '.bin';
        file_put_contents(__DIR__ . '/../../public/uploads/foto/' . $namaBerkas, $isi);

        Karyawan::updateFotoUrl($idUser, $url);

        return [
            'sukses' => true,
            'pesan' => 'Berhasil mengambil konten dari URL sebagai foto profil (' . strlen($isi) . ' byte).',
        ];
    }
}
