<?php
/**
 * Modul Master Karyawan. Lihat desain_dan_kebutuhan_aplilkasi.md §9.1 & §9.2.
 * CWE yang didemonstrasikan: CWE-639 IDOR, CWE-862 Missing Authorization,
 * CWE-476 NULL Pointer Dereference, CWE-89 SQL Injection (titik kedua),
 * CWE-209 Verbose Error Message, CWE-521 Weak Password Requirements,
 * CWE-918 SSRF.
 */

class KaryawanController
{
    /**
     * CWE-639 IDOR / Authorization Bypass via User-Controlled Key: form
     * profil mengirim `id_karyawan` sebagai hidden input yang DIPERCAYA
     * server saat UPDATE — bukan diambil dari identitas sesi yang sedang
     * login.
     */
    public function profil(): void
    {
        AuthMiddleware::handle();

        $idKaryawan = (int) ($_SESSION['user_id'] ?? 1);
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- CWE-639: id_karyawan diambil dari hidden input form, bukan dari sesi ---
            $idDariForm = (int) $idKaryawan;
            $nama = $_POST['nama'] ?? '';

            Karyawan::updateNama($idDariForm, $nama);
            $message = "Profil pegawai id=$idDariForm berhasil diperbarui.";
        }

        $karyawan = Karyawan::findById($idKaryawan) ?: ['id' => $idKaryawan, 'nama' => ''];

        $pageTitle = 'Profil Saya';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/karyawan/profil.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    /**
     * CWE-862 Missing Authorization: endpoint hapus menjalankan DELETE
     * tanpa memeriksa sesi maupun role SAMA SEKALI — cukup tahu URL-nya.
     * (Bandingkan dengan CWE-639 di profil(): di sana identitas DIPERIKSA
     * tapi salah sumber; di sini pemeriksaannya TIDAK ADA sama sekali —
     * perhatikan AuthMiddleware::handle() SENGAJA TIDAK dipanggil di sini.)
     */
    public function hapus(): void
    {
        AuthMiddleware::handle();

        if(($_SESSION['role'] ?? null) !== 'hrd'){
            http_response_code(403);
            exit("Akses tidak diijinkan");
        }
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            Karyawan::delete($id);
        }

        header('Location: ' . APP_URL . '/karyawan/cari.php');
        exit;
    }

    /**
     * CWE-476 NULL Pointer Dereference: hasil pencarian dipakai langsung
     * (`$data->nama`) tanpa memeriksa apakah datanya ditemukan.
     */
    public function detail(): void
    {
        AuthMiddleware::handle();

        $id = (int) ($_GET['id'] ?? 0);
        $row = Karyawan::findById($id);

        // --- CWE-476: TIDAK ADA pengecekan apakah $row kosong sebelum dipakai sebagai objek ---
        $data = $row ? (object) $row : null;

        $pageTitle = 'Detail Pegawai';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/karyawan/detail.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    /**
     * CWE-89 SQL Injection: titik injeksi KEDUA pada SIMPEG (titik pertama
     * ada di AuthController::login()) — keyword pencarian digabung langsung
     * ke query. CWE-209 Verbose Error Message: pesan error PDO asli
     * ditampilkan ke pengguna.
     */
    public function cari(): void
    {
        AuthMiddleware::handle();

        $keyword = $_GET['q'] ?? '';
        $rows = [];
        $errorMessage = null;

        // if ($keyword !== '') {
        try {
            $rows = Karyawan::searchByNamaRaw($keyword);
        } catch (PDOException $e) {
            // --- CWE-209: detail error SQL asli (nama tabel/kolom) ditampilkan ke pengguna ---
            $errorMessage = $e->getMessage();
        }
        // }

        $pageTitle = 'Pencarian Pegawai';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/karyawan/cari.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    /**
     * CWE-521 Weak Password Requirements: validasi hanya memeriksa panjang
     * minimal 4 karakter (lihat Auth::isPasswordAcceptable).
     */
    public function gantiPassword(): void
    {
        AuthMiddleware::handle();

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $baru = $_POST['password_baru'] ?? '';

            // --- CWE-521: satu-satunya validasi hanyalah panjang minimal 4 karakter ---
            if (Auth::isPasswordAcceptable($baru)) {
                User::updatePassword(Auth::id(), Auth::hashPassword($baru));
                $message = 'Kata sandi berhasil diganti.';
            } else {
                $message = 'Kata sandi terlalu pendek (minimal 4 karakter).';
            }
        }

        $pageTitle = 'Ganti Kata Sandi';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/karyawan/ganti_password.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }

    public function fotoDariUrl(): void
    {
        AuthMiddleware::handle();

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hasil = FotoProfilService::ambilDariUrl($_POST['url_foto'] ?? '', Auth::id());
            $message = $hasil['pesan'];
        }

        $pageTitle = 'Foto Profil dari URL';
        require __DIR__ . '/../../resources/views/layouts/header.php';
        require __DIR__ . '/../../resources/views/pages/karyawan/foto_dari_url.php';
        require __DIR__ . '/../../resources/views/layouts/footer.php';
    }
}
