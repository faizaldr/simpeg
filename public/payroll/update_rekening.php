<?php
/**
 * Front controller tipis — lihat app/Controllers/PayrollController.php::updateRekening()
 * untuk kerentanan CWE-352 CSRF (tidak ada token pada form).
 */
require_once __DIR__ . '/../../config/config.php';

(new PayrollController())->updateRekening();
