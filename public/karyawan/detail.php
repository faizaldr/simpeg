<?php
/**
 * Front controller tipis — lihat app/Controllers/KaryawanController.php::detail()
 * untuk kerentanan CWE-476 NULL Pointer Dereference.
 */
require_once __DIR__ . '/../../config/config.php';

(new KaryawanController())->detail();
