<?php
/**
 * Front controller tipis — lihat app/Controllers/PayrollController.php::proses()
 * dan app/Helpers/Auth.php::currentRole() untuk kerentanan CWE-807 (Critical).
 */
require_once __DIR__ . '/../../config/config.php';

(new PayrollController())->proses();
