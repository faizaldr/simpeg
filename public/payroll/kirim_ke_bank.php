<?php
/**
 * Front controller tipis — lihat app/Controllers/PayrollController.php::kirimKeBank()
 * dan app/Services/PayrollService.php untuk kerentanan CWE-319 Cleartext Transmission.
 */
require_once __DIR__ . '/../../config/config.php';

(new PayrollController())->kirimKeBank();
