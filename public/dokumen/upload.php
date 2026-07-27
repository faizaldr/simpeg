<?php
/**
 * Front controller tipis — lihat app/Controllers/DokumenController.php::upload()
 * dan app/Services/DokumenService.php untuk kerentanan CWE-434 Unrestricted File Upload.
 */
require_once __DIR__ . '/../../config/config.php';

(new DokumenController())->upload();
