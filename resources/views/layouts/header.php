<?php
/**
 * Layout atas (head + topbar + sidebar) untuk halaman yang sudah login.
 * Variabel opsional dari pemanggil: $pageTitle.
 *
 * CWE-829 Inclusion from Untrusted Control Sphere: mengikuti pola asli
 * template AdminLTE v4 hasil unduhan (public/assets/vendor/adminlte/index.html) —
 * skrip popper & bootstrap dimuat dari CDN jsdelivr HANYA dengan `crossorigin`,
 * TANPA atribut `integrity` (Subresource Integrity), persis seperti pada
 * berkas template aslinya.
 */
$pageTitle = $pageTitle ?? 'SIMPEG';
$role = Auth::currentRole();
header("Content-Security-Policy: default-src 'self' https://cdn.jsdelivr.net; script-src 'self' https://cdn.jsdelivr.net");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($pageTitle) ?> - SIMPEG</title>
    <link rel="stylesheet" href="/assets/vendor/adminlte/css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!-- Tombol hamburger: memunculkan/menyembunyikan sidebar di layar kecil (<lg).
                         Tanpa ini, sidebar hanya tersembunyi begitu saja di mode mobile karena
                         class body "sidebar-expand-lg" menyembunyikannya secara default. -->
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <span class="navbar-brand mb-0">SIMPEG</span>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <!-- Menu akun: satu-satunya jalur tampilan menuju profil, ganti kata sandi,
                     foto dari URL, dan preferensi dashboard — sebelumnya halaman-halaman ini
                     tidak punya tautan sama sekali di UI. -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        <span><?= htmlspecialchars($_SESSION['username'] ?? '-') ?> (<?= htmlspecialchars($role ?? '-') ?>)</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="/karyawan/profil.php" class="dropdown-item"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                        <li><a href="/karyawan/ganti_password.php" class="dropdown-item"><i class="bi bi-key me-2"></i>Ganti Kata Sandi</a></li>
                        <li><a href="/karyawan/foto_dari_url.php" class="dropdown-item"><i class="bi bi-image me-2"></i>Foto Profil dari URL</a></li>
                        <li><a href="/dashboard/preferensi.php" class="dropdown-item"><i class="bi bi-sliders me-2"></i>Preferensi Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="/auth/logout.php" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand"><span class="brand-text fw-light">SIMPEG</span></div>
        <div class="sidebar-wrapper">
            <ul class="nav sidebar-menu flex-column">
                <li class="nav-item"><a href="/index.php?page=dashboard" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="/karyawan/cari.php" class="nav-link">Data Karyawan</a></li>
                <li class="nav-item"><a href="/cuti/daftar.php" class="nav-link">Pengajuan Cuti</a></li>
                <li class="nav-item"><a href="/absensi/import.php" class="nav-link">Import Absensi</a></li>
                <li class="nav-item"><a href="/payroll/proses.php" class="nav-link">Payroll</a></li>
                <li class="nav-item"><a href="/dokumen/upload.php" class="nav-link">Dokumen</a></li>
                <li class="nav-item"><a href="/laporan/ekspor.php" class="nav-link">Ekspor Laporan</a></li>
                <li class="nav-item"><a href="/settings/rumus_tunjangan.php" class="nav-link">Pengaturan</a></li>
            </ul>
        </div>
    </aside>
    <main class="app-main">
        <div class="app-content">
            <div class="container-fluid">
