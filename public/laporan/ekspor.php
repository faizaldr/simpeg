<?php
/**
 * Front controller tipis — lihat app/Controllers/LaporanController.php::ekspor()
 * untuk kerentanan CWE-799 Improper Control of Interaction Frequency.
 */
require_once __DIR__ . '/../../config/config.php';

(new LaporanController())->ekspor();
