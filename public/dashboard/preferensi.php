<?php
/**
 * Front controller tipis — lihat app/Controllers/DashboardController.php::preferensi()
 * dan app/Helpers/PreferensiWidget.php untuk kerentanan CWE-502 Insecure Deserialization.
 */
require_once __DIR__ . '/../../config/config.php';

(new DashboardController())->preferensi();
