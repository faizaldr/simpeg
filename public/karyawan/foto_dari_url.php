<?php
/**
 * Front controller tipis — lihat app/Controllers/KaryawanController.php::fotoDariUrl()
 * dan app/Services/FotoProfilService.php untuk kerentanan CWE-918 SSRF.
 */
require_once __DIR__ . '/../../config/config.php';

(new KaryawanController())->fotoDariUrl();
