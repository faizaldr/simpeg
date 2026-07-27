<?php
/**
 * Front controller tipis — lihat app/Controllers/CutiController.php::daftar()
 * dan resources/views/pages/cuti/daftar.php untuk kerentanan CWE-79 Stored XSS.
 */
require_once __DIR__ . '/../../config/config.php';

(new CutiController())->daftar();
