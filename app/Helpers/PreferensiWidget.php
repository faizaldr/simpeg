<?php
/**
 * Objek preferensi dashboard sederhana — dipakai untuk mendemonstrasikan
 * CWE-502 (lihat public/dashboard/preferensi.php). Magic method __wakeup()
 * di sini mewakili "efek samping" yang bisa dipicu saat unserialize()
 * dijalankan terhadap objek yang disusun bebas oleh pengguna (gadget
 * sederhana untuk keperluan demo kelas, bukan RCE sungguhan).
 */
class PreferensiWidget
{
    public string $tema;

    public function __construct(string $tema = 'default')
    {
        $this->tema = $tema;
    }

    public function __wakeup(): void
    {
        // Efek samping yang terjadi begitu objek ini di-unserialize — pada
        // contoh nyata, gadget seperti ini bisa dipakai untuk menulis
        // berkas, memanggil method lain, dsb. Di sini hanya mencatat waktu.
        @file_put_contents(
            __DIR__ . '/../../storage/cache/preferensi_wakeup.log',
            date('c') . " - PreferensiWidget di-unserialize dengan tema='{$this->tema}'\n",
            FILE_APPEND
        );
    }
}
