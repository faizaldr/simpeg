<?php
/**
 * Front controller tipis — lihat app/Controllers/KaryawanController.php::hapus()
 * untuk kerentanan CWE-862 Missing Authorization (perhatikan AuthMiddleware
 * SENGAJA tidak dipanggil di sana).
 */
require_once __DIR__ . '/../../config/config.php';

(new KaryawanController())->hapus();
