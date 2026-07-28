<?php
/**
 * Enkripsi data sensitif (nomor rekening, dsb).
 *
 * CWE-321 Hard-coded Cryptographic Key: kunci ditulis permanen di kode,
 * sama untuk semua instalasi. Lihat desain_dan_kebutuhan_aplilkasi.md §9.2.
 */

// CWE-321: kunci enkripsi hardcode (jangan pernah lakukan ini di produksi).
define('ENC_KEY', base64_decode($_ENV['ENCRYPTION_KEY'] ?? ''));

define('ENC_METHOD', 'AES-256-CBC');

class Crypto
{
    public static function encrypt(string $plain): string
    {
        // CWE-329-adjacent: IV statis (turunan dari ENC_KEY) demi kesederhanaan demo — bukan acak per operasi.
        $iv = substr(md5(ENC_KEY), 0, 16);
        $cipher = openssl_encrypt($plain, ENC_METHOD, ENC_KEY, 0, $iv);

        return base64_encode($cipher);
    }

    public static function decrypt(string $encoded): string|false
    {
        $iv = substr(md5(ENC_KEY), 0, 16);
        $cipher = base64_decode($encoded);

        return openssl_decrypt($cipher, ENC_METHOD, ENC_KEY, 0, $iv);
    }
}
