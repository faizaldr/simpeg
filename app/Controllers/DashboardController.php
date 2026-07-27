<?php
/**
 * CWE-502 Deserialization of Untrusted Data: nilai cookie `pref` (yang
 * berasal sepenuhnya dari klien) diproses lewat unserialize() SEBELUM ada
 * pemeriksaan lanjutan apa pun — objek yang disusun khusus oleh penyerang
 * ikut diproses server.
 */

class DashboardController
{
    public function preferensi(): void
    {
        AuthMiddleware::handle();

        // --- CWE-502: unserialize() langsung terhadap data dari cookie klien ---
        $preferensi = isset($_COOKIE['pref'])
            ? unserialize($_COOKIE['pref'])
            : new PreferensiWidget('default');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $preferensi = new PreferensiWidget($_POST['tema'] ?? 'default');
            setcookie('pref', serialize($preferensi), time() + 86400, '/');
            header('Location: ' . APP_URL . '/dashboard/preferensi.php');
            exit;
        }

        $pageTitle = 'Preferensi Dashboard';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/dashboard/preferensi.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}
