<?php
/**
 * Front controller tipis — lihat app/Controllers/KaryawanController.php::gantiPassword()
 * dan app/Helpers/Auth.php::isPasswordAcceptable() untuk kerentanan CWE-521.
 */
require_once __DIR__ . '/../../config/config.php';

(new KaryawanController())->gantiPassword();
