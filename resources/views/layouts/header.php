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
            <span class="ms-auto text-muted small">
                <?= htmlspecialchars($_SESSION['username'] ?? '-') ?> (<?= htmlspecialchars($role ?? '-') ?>)
                &middot; <a href="/auth/logout.php">Keluar</a>
            </span>
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
