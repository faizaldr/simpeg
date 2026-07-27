<?php
/**
 * Modul Pengaturan Sistem. Logika eval() rumus tunjangan (CWE-94) ada di
 * app/Services/RumusTunjanganService.php.
 */

class SettingsController
{
    public function rumusTunjangan(): void
    {
        AuthMiddleware::handle();

        $hasil = null;
        $rumusTersimpan = RumusTunjanganService::rumusTersimpan();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rumusTersimpan = $_POST['rumus'] ?? '';
            $hasil = RumusTunjanganService::simpanDanHitungContoh($rumusTersimpan);
        }

        $pageTitle = 'Pengaturan Rumus Tunjangan';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/settings/rumus_tunjangan.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}
