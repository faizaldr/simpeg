<?php
/**
 * Front controller tipis — lihat app/Controllers/CutiController.php::setujui()
 * untuk kerentanan CWE-1021 Clickjacking (tidak ada header X-Frame-Options).
 */
require_once __DIR__ . '/../../config/config.php';

(new CutiController())->setujui();
