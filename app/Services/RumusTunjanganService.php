<?php
/**
 * CWE-94 Code Injection: rumus perhitungan tunjangan yang dimasukkan HRD
 * dijalankan LANGSUNG lewat eval() — kode PHP apa pun yang disisipkan di
 * dalam rumus ikut tereksekusi di server, bukan cuma operasi matematika.
 */

class RumusTunjanganService
{
    public static function simpanDanHitungContoh(string $rumusBaru): float|int|null
    {
        $masa_kerja = 5; // contoh variabel yang tersedia untuk rumus

        $token = str_replace('masa_kerja', (string) $masa_kerja, $rumusBaru);
        if (!preg_match('/^[\d\s+\-*\/().]+$/', $token))
            exit('Rumus Mengandung Karakter yang diijinkan');

        PengaturanSistem::set('rumus_tunjangan', $rumusBaru);


        // --- CWE-94: eval() menjalankan rumus sebagai kode PHP sungguhan ---
        eval ('$hasil = ' . $rumusBaru . ';');

        return $hasil ?? null;
    }

    public static function rumusTersimpan(): string
    {
        return PengaturanSistem::get('rumus_tunjangan', '2000000 + (masa_kerja * 50000)');
    }
}
