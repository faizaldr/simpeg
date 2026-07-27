<?php
/**
 * Front controller tipis — lihat app/Controllers/PayrollController.php::download()
 * untuk kerentanan CWE-22 Path Traversal.
 */
require_once __DIR__ . '/../../config/config.php';

(new PayrollController())->download();
