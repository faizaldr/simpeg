<?php
/**
 * Modul Login SIMPEG — baseline SENGAJA RENTAN. Lihat pemetaan lengkap di
 * desain_dan_kebutuhan_aplilkasi.md §9.1 & §9.3, dan panduan uji di
 * langkah_pengujian_kerentanan_dan_patching.md (Hari 1 & Hari 3).
 *
 * CWE yang didemonstrasikan di controller ini:
 *  - CWE-89  SQL Injection (query dibentuk lewat konkatenasi string — lihat User::findByUsernameRaw())
 *  - CWE-328 Reversible One-Way Hash (verifikasi via Auth::verifyPassword/md5)
 *  - CWE-259 Hard-coded Password (akun cadangan "superadmin" tertanam di kode)
 *  - CWE-489 Active Debug Code (parameter ?bypass=dev123)
 *  - CWE-601 Open Redirect (parameter ?redirect= dipakai apa adanya)
 *  - CWE-614 & CWE-1004 Cookie tanpa Secure/HttpOnly (cookie remember_token)
 *  - CWE-384 Session Fixation (lihat Auth::login() - tidak regenerasi ID)
 *  - CWE-307 Improper Restriction of Authentication Attempts (tidak ada limit percobaan)
 *  - CWE-319 Cleartext Transmission (form action dipaksa skema http://)
 *  - CWE-90  LDAP Injection (lihat ssoLogin() & app/Services/SimulatedLdap.php)
 */

class AuthController
{
    public function login(): void
    {
        $error = null;

        // --- CWE-489 Active Debug Code: backdoor bypass peninggalan developer ---
        // if (isset($_GET['bypass']) && $_GET['bypass'] === 'dev123') {
        //     $_SESSION['user_id'] = 0;
        //     $_SESSION['username'] = 'dev-bypass';
        //     $_SESSION['role'] = 'hrd';
        //     header('Location: ' . APP_URL . '/index.php?page=dashboard');
        //     exit;
        // }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // --- CWE-259 Hard-coded Password: akun cadangan tertanam permanen di kode ---
            if ($username === 'superadmin' && $password === 'Simpeg#2024') {
                Auth::login(['id' => 0, 'username' => 'superadmin', 'role' => 'hrd']);
                header('Location: ' . APP_URL . '/index.php?page=dashboard');
                exit;
            }

            // --- CWE-89 SQL Injection: konkatenasi string langsung ke query ---
            $user = User::findByUsernameRaw($username);

            if ($user && Auth::verifyPassword($password, $user['password'])) {
                Auth::login($user);

                // --- CWE-614 & CWE-1004: cookie "ingat saya" tanpa flag Secure/HttpOnly ---
                if (!empty($_POST['ingat_saya'])) {
                    $token = Auth::generateToken(); // CWE-338: uniqid(), bukan CSPRNG
                    setcookie('remember_token', $token, time() + 2592000, '/');
                }

                // --- CWE-601 Open Redirect: nilai parameter dipakai apa adanya ---
                $redirect = $_GET['redirect'] ?? (APP_URL . '/index.php?page=dashboard');
                header('Location: ' . $redirect);
                exit;
            }

            // --- CWE-307: TIDAK ADA penghitung kegagalan/penundaan/CAPTCHA di sini ---
            $error = 'Username atau kata sandi salah.';
        }

        $httpHost = $_SERVER['HTTP_HOST'];
        require __DIR__ . '/../../resources/views/pages/auth/login.php';
    }

    public function logout(): void
    {
        // --- CWE-613 (lihat catatan lengkap di app/Helpers/Auth.php & config/config.php):
        // logout HANYA menghapus cookie di sisi browser, TIDAK ADA session_destroy()/session_unset() ---
        setcookie(session_name(), '', time() - 3600, '/');

        header('Location: ' . APP_URL . '/auth/login.php');
        exit;
    }

    /**
     * Login SSO ke "LDAP kantor pusat" (disimulasikan — lihat
     * app/Services/SimulatedLdap.php, karena lab ini tidak menyediakan
     * server LDAP sungguhan).
     */
    public function ssoLogin(): void
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $usernameFilter = ldap_escape($username, '', LDAP_ESCAPE_FILTER);

            // --- CWE-90: filter dibentuk lewat konkatenasi string, tanpa ldap_escape() ---
            // $filter = '(uid=' . $username . ')';
            $filter = '(uid=' . $usernameFilter . ')';

            $entry = SimulatedLdap::search($filter);

            if ($entry && SimulatedLdap::bind($entry['uid'], $password)) {
                Auth::login(['id' => 0, 'username' => $entry['uid'], 'role' => $entry['role']]);
                header('Location: ' . APP_URL . '/index.php?page=dashboard');
                exit;
            }

            $error = 'Pengguna tidak ditemukan di direktori LDAP.';
        }

        require __DIR__ . '/../../resources/views/pages/auth/sso_login.php';
    }
}
