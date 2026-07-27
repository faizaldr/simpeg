<?php
/**
 * Front controller tipis — lihat app/Controllers/CutiController.php::ajukan()
 * dan app/Services/CutiService.php untuk kerentanan CWE-362 Race Condition.
 */
require_once __DIR__ . '/../../config/config.php';

(new CutiController())->ajukan();
