<?php
/**
 * Front controller tipis — lihat app/Controllers/AbsensiController.php::import()
 * dan app/Services/AbsensiImportService.php untuk kerentanan CWE-611 XXE
 * dan CWE-248 Uncaught Exception.
 */
require_once __DIR__ . '/../../config/config.php';

(new AbsensiController())->import();
