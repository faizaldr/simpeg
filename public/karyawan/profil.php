<?php
/**
 * Front controller tipis — lihat app/Controllers/KaryawanController.php::profil()
 * dan app/Models/Karyawan.php untuk kerentanan CWE-639 IDOR.
 */
require_once __DIR__ . '/../../config/config.php';

(new KaryawanController())->profil();
