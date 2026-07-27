<?php
/**
 * Front controller tipis — lihat app/Controllers/AuthController.php::logout()
 * untuk kerentanan CWE-613 Insufficient Session Expiration.
 */
require_once __DIR__ . '/../../config/config.php';

(new AuthController())->logout();
