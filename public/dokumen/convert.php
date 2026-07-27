<?php
/**
 * Front controller tipis — lihat app/Controllers/DokumenController.php::convert()
 * dan app/Services/DokumenService.php untuk kerentanan CWE-78 OS Command Injection.
 */
require_once __DIR__ . '/../../config/config.php';

(new DokumenController())->convert();
