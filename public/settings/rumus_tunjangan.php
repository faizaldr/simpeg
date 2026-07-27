<?php
/**
 * Front controller tipis — lihat app/Controllers/SettingsController.php::rumusTunjangan()
 * dan app/Services/RumusTunjanganService.php untuk kerentanan CWE-94 Code Injection.
 */
require_once __DIR__ . '/../../config/config.php';

(new SettingsController())->rumusTunjangan();
