<?php
/**
 * Front controller tipis — lihat app/Controllers/KaryawanController.php::cari()
 * dan app/Models/Karyawan.php untuk kerentanan CWE-89 SQL Injection & CWE-209
 * Verbose Error Message.
 */
require_once __DIR__ . '/../../config/config.php';

(new KaryawanController())->cari();
