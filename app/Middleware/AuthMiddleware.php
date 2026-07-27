<?php
/**
 * Middleware pemeriksaan sesi login. Dipanggil di awal setiap Controller
 * yang MEMANG mensyaratkan login.
 *
 * Catatan penting untuk peserta: `KaryawanController::hapus()` (CWE-862)
 * dan `PayrollController::updateRekening()` (CWE-352, aksi tulisnya)
 * SENGAJA tidak memanggil middleware ini / tidak memverifikasi cukup —
 * bandingkan langsung dua controller tersebut untuk melihat bedanya.
 */

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check()) {
            header('Location: ' . APP_URL . '/auth/login.php');
            exit;
        }
    }
}
