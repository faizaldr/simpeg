<?php
/**
 * Bootstrap konfigurasi aplikasi SIMPEG.
 * Baseline lab (sengaja rentan) — lihat desain_dan_kebutuhan_aplilkasi.md §9.
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

define('APP_URL', $_ENV['APP_URL'] ?? 'http://simpeg.test');
define('SEED_EMAIL_DOMAIN', $_ENV['SEED_EMAIL_DOMAIN'] ?? 'inixindo.id');

define('DB_HOST', $_ENV['DB_HOST'] ?? '127.0.0.1');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');
define('DB_DATABASE', $_ENV['DB_DATABASE'] ?? 'simpeg');
define('DB_USERNAME', $_ENV['DB_USERNAME'] ?? 'root');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');

// --- CWE-209 & CWE-248 & CWE-476: error/exception PHP ditampilkan apa adanya ---
// (kondisi rentan baseline: display_errors aktif, tidak ada exception handler global)
ini_set('display_errors', '1');
error_reporting(E_ALL);

// --- CWE-613: Insufficient Session Expiration ---
// Sesi sengaja dibuat berumur sangat panjang (30 hari) agar "pengguna tidak perlu sering login ulang".
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
session_set_cookie_params(60 * 60 * 24 * 30);

// --- CWE-614 & CWE-1004: cookie sesi TANPA flag Secure/HttpOnly ---
// (kondisi rentan: sengaja tidak diaktifkan di baseline)
ini_set('session.cookie_httponly', 0);
ini_set('session.cookie_secure', 0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Kelas di app/Models, app/Controllers, app/Services, app/Middleware,
 * app/Helpers SENGAJA tidak memakai namespace (mis. `class Karyawan`, bukan
 * `App\Models\Karyawan`) supaya peserta pemula tidak perlu berurusan dengan
 * PSR-4/namespace saat membaca kode.
 *
 * Loading utamanya lewat classmap Composer (lihat composer.json →
 * autoload.classmap, sudah aktif otomatis via vendor/autoload.php di atas).
 * Autoloader tambahan di bawah ini murni jaring pengaman: bila peserta
 * menambah berkas kelas baru tapi lupa menjalankan `composer dump-autoload`,
 * kelasnya tetap ditemukan lewat pemindaian folder secara langsung.
 */
spl_autoload_register(function (string $class): void {
    foreach (['Helpers', 'Models', 'Services', 'Controllers', 'Middleware'] as $folder) {
        $path = __DIR__ . "/../app/$folder/$class.php";
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
