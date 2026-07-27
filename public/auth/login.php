<?php
/**
 * Front controller tipis — logika & kerentanan sesungguhnya ada di
 * app/Controllers/AuthController.php (lihat komentar di sana untuk daftar
 * lengkap CWE yang didemonstrasikan modul Login).
 */
require_once __DIR__ . '/../../config/config.php';

(new AuthController())->login();
