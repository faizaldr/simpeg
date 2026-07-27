# Inisialisasi Proyek Lab: SIMPEG Rentan (Studi Kasus OWASP Top 10:2025)

Panduan ini ditulis untuk menggunakan aplikasi SIMPEG yang rentan. Ikuti langkah berikut ini dari atas ke bawah.

> **Catatan notasi:** setiap kali panduan ini menulis `<folder-proyek>`, ganti dengan lokasi folder proyek `simpeg` Anda sendiri (di mana pun itu disimpan). Setiap kali menulis `<lokasi-laragon>`, ganti dengan folder tempat Laragon terpasang (default instalasi Laragon adalah `C:\laragon`).

## 0. Apa yang sedang kita bangun?

Kita akan membuat **SIMPEG (Sistem Informasi Kepegawaian)** tiruan yang **sengaja dibuat rentan**, sebagai bahan praktikum kelas untuk mempelajari OWASP_Top10_2025

Setiap baris di checklist punya kolom **Example 2 — Kode Rentan (PHP)** dan **Example 1 — Modul SIMPEG**, artinya checklist itu sudah dirancang mengikuti modul-modul SIMPEG seperti: Login, Data Karyawan, Slip Gaji, Pengajuan Cuti, Absensi, Upload Dokumen, Backup, API Karyawan, dll. Modul-modul inilah yang akan kita bangun bertahap di sesi-sesi berikutnya, dengan kerentanan disuntikkan sesuai baris checklist.

Tahap ini (**inisialisasi**) hanya menyiapkan pondasinya: Laragon aktif, proyek bisa diakses di browser, dan database siap. Pembuatan modul rentan satu per satu dilakukan di sesi lanjutan.

## 1. Peringatan Keamanan & Etika (WAJIB dibaca)

- Proyek ini **sengaja rentan**. **JANGAN** pernah menaruhnya di server publik / hosting / internet.
- Jalankan **hanya di `localhost`** (komputer sendiri), idealnya di perangkat yang tidak dipakai untuk data pribadi/sensitif sungguhan.
- Jangan gunakan data pegawai asli. Gunakan data dummy/fiktif saja (nama, NIK, gaji semua rekayasa).
- Nonaktifkan server (Apache & MySQL di Laragon) saat tidak dipakai praktikum.
- Jika perangkat terhubung ke Wi-Fi kampus/publik, pastikan tidak ada port-forwarding yang membuat `localhost` bisa diakses dari luar.

## 2. Prasyarat

- **Laragon** (paket portable Apache + PHP + MySQL/MariaDB untuk Windows) sudah terpasang. Versi PHP/MySQL bawaan tidak masalah selama termasuk rilis stabil terbaru — panduan ini tidak bergantung pada versi spesifik.
- Folder proyek `simpeg` sudah ada (berisi template tampilan AdminLTE) di lokasi mana pun yang Anda pilih di komputer — sebut lokasi ini `<folder-proyek>`.
- File `OWASP_Top10_2025.xlsx` sebagai checklist pengujian, disimpan di lokasi yang mudah diakses (boleh berdampingan dengan `<folder-proyek>`).
- (Opsional, dipakai belakangan) **OWASP ZAP** atau proxy pengujian sejenis, untuk sesi praktikum lanjutan.

## 3. Konsep dasar: Document Root Laragon

Laragon melayani halaman web dari satu folder yang disebut **Document Root**. Secara default, Document Root ini adalah folder `www` di dalam instalasi Laragon (`<lokasi-laragon>\www`), dan setiap subfolder di dalamnya otomatis bisa diakses lewat browser.

Yang penting diketahui:

- Document Root **bisa diarahkan ke folder mana pun** lewat menu setting Laragon (dijelaskan di Langkah 2) — artinya proyek **tidak wajib disalin** ke lokasi instalasi Laragon. Anda bisa menyimpan proyek di folder pilihan sendiri dan cukup memberi tahu Laragon lokasinya.
- Kalau Document Root default sudah dipakai oleh proyek lain (mis. praktikum/aplikasi lain yang sedang berjalan), jangan menghapus atau menimpanya. Solusinya cukup arahkan Document Root ke folder induk proyek SIMPEG (Langkah 2) — proyek lain di Document Root lama tidak akan terhapus, hanya sementara tidak ikut terlayani selama Document Root diarahkan ke folder lain. Untuk kembali melayani proyek lama, kembalikan saja nilai Document Root ke lokasi semula.

## 4. Langkah 1 — Jalankan Laragon

1. Buka aplikasi **Laragon** (lewat shortcut Desktop/Start Menu, atau file `laragon.exe` di folder instalasinya).
2. Di jendela Laragon, klik tombol **Start All**. Tunggu sampai indikator **Apache** dan **MySQL** berwarna hijau/menyala.
3. Jika muncul pop-up izin firewall, izinkan aksesnya.
4. Kalau Apache gagal start karena port 80 sudah dipakai aplikasi lain, klik kanan Laragon → **Apache** → **Port** → ganti ke port lain (mis. `8080`), lalu **Start All** lagi. (Kalau ini terjadi, semua alamat `http://...` di panduan ini perlu ditambah nomor port tersebut, misalnya `http://simpeg.test:8080`.)

## 5. Langkah 2 — Arahkan Document Root Laragon ke folder proyek

Proyek `simpeg` tetap berada di `<folder-proyek>` — **tidak perlu disalin/dipindah** ke lokasi Laragon. Kita cukup memberi tahu Laragon lewat menu setting agar melayani folder itu langsung:

1. Buka **Laragon** (pastikan sudah **Start All** seperti Langkah 1).
2. Klik ikon **⚙️ (gear/setting)** di jendela Laragon, atau klik kanan ikon Laragon di system tray → pilih **Preferences...**
3. Di jendela **Preferences**, buka tab **General**.
4. Cari bagian **Document Root**.
5. Klik tombol **...** (browse) di sebelah kolom Document Root, lalu arahkan ke **folder induk** yang berisi folder proyek `simpeg` (bukan folder `simpeg` itu sendiri — supaya Auto Virtual Host tetap membuatkan alamat `simpeg.test` dari subfoldernya).
6. Klik **OK/Save**, lalu **restart Laragon** (klik **Stop All** kemudian **Start All** lagi) supaya perubahan Document Root diterapkan.

> Dengan cara ini, folder proyek tetap satu-satunya sumber kebenaran — tidak ada salinan ganda yang bisa membuat bingung file mana yang sedang diedit. Kalau suatu saat proyek dipindah ke folder lain, cukup ubah lagi nilai **Document Root** ini, tanpa perlu menyalin file apa pun.

## 6. Langkah 3 — Buka proyek di browser

Laragon punya fitur **Auto Virtual Hosts**: setiap subfolder di dalam Document Root otomatis punya alamat `<namafolder>.test`. Karena Document Root sekarang adalah folder induk proyek, subfolder `simpeg` di dalamnya otomatis menjadi `simpeg.test`.

> **Catatan struktur folder `public/`:** proyek `simpeg` mengikuti struktur standar Composer, di mana document root sesungguhnya adalah `simpeg/public/` (lihat `simpeg/README.md`), bukan `simpeg/` itu sendiri. Laragon otomatis mendeteksi folder `public/` pada proyek yang di-serve lewat Auto Virtual Host dan mengarahkan `simpeg.test` ke `simpeg/public/`. Bila ternyata tidak otomatis, atur manual: klik kanan proyek `simpeg` pada daftar situs Laragon → **Web root** → arahkan ke `public`.

1. Buka browser, akses: **http://simpeg.test/**
   - `public/index.php` akan mengarahkan ke halaman login bila sesi belum ada (butuh `composer install` & database terisi lebih dulu — lanjutkan ke Langkah 4–5). Untuk verifikasi cepat tanpa itu, coba: **http://simpeg.test/assets/vendor/adminlte/index.html** — halaman demo dashboard AdminLTE seharusnya muncul.
2. Jika `simpeg.test` tidak bisa diakses sama sekali:
   - Pastikan Document Root di Preferences → General sudah benar-benar tersimpan ke folder induk proyek.
   - Klik kanan ikon Laragon → **www** (atau **Root**) → pastikan `simpeg` muncul dalam daftar.
   - Klik kanan ikon Laragon → **Refresh DNS** (atau restart Laragon sepenuhnya).
3. Alternatif tanpa Auto Virtual Host: **http://localhost/simpeg/public/assets/vendor/adminlte/index.html**

Kalau langkah ini berhasil menampilkan dashboard AdminLTE, artinya Apache + PHP sudah bisa melayani folder proyek dengan benar. ✅

## 7. Langkah 4 — Siapkan database MySQL

1. Klik kanan ikon Laragon di system tray → **Database** → **phpMyAdmin** (atau **HeidiSQL** — keduanya sudah terpasang otomatis oleh Laragon, tidak perlu instal lagi).
2. Kalau muncul login, kredensial default paket Laragon:
   - Username: `root`
   - Password: *(kosong)*
3. Buat database baru bernama: **`simpeg`**
   - phpMyAdmin: klik **New** di sidebar kiri → ketik `simpeg` → **Create**.
   - HeidiSQL: klik kanan koneksi → **Create new** → **Database** → beri nama `simpeg`.
4. Database `simpeg` masih kosong di titik ini — tabel-tabel (`user`, `karyawan`, `cuti`, `absensi`, dst) beserta data dummy-nya baru terisi setelah menjalankan `composer run app:install` pada Langkah 5.

## 8. Langkah 5 — Siapkan dependensi & konfigurasi lewat Composer

Proyek `simpeg` sudah memakai struktur folder standar berbasis Composer (lihat `simpeg/README.md`) — koneksi database **tidak lagi ditulis manual** ke `config/db.php`, tetapi lewat `.env` yang dibaca aplikasi nanti.

1. Buka **Terminal** Laragon (klik kanan ikon Laragon → **Terminal**), pindah ke folder proyek: `cd <folder-proyek>/simpeg`.
2. Salin berkas contoh konfigurasi: `cp .env.example .env` (atau salin manual lewat File Explorer bila `cp` tidak tersedia).
3. Sesuaikan isi `.env` bila kredensial database berbeda dari bawaan Laragon (`root` tanpa password) — nilai bawaan biasanya sudah cocok.
4. Jalankan `composer install` untuk mengunduh seluruh dependensi PHP (Phinx, Faker, phpdotenv) sekaligus aset front-end (AdminLTE, jQuery, plugin) lewat asset-packagist. Butuh koneksi internet dan Composer terpasang (`composer -V` untuk memastikan).

Tahap ini baru menyiapkan kerangka & dependensi — pembuatan tabel dan data dummy (lewat `composer run app:install`) menyusul setelah class migration/seeder-nya dibuat pada sesi implementasi modul.

## 9. Langkah 6 — Siapkan checklist pengujian

1. Simpan `OWASP_Top10_2025.xlsx` di lokasi yang mudah diakses saat praktikum (boleh berdampingan dengan `<folder-proyek>`).
2. Buka filenya di Excel/LibreOffice/Google Sheets, kenali 3 sheet-nya:
   - **`OWASP Top 10 2025 Checklist`** — 249 baris kerentanan, tiap baris berisi kode PHP rentan contoh, skenario eksploitasi, dan cara perbaikannya.
   - **`Legend & Instructions`** — arti simbol status (☐ Not Tested, 🔄 In Progress, ✅ Pass, ❌ Fail, ➖ N/A, ⚠️ Needs Review) dan level severity (Critical/High/Medium/Low/Informational).
   - **`Category Summary`** — rekap jumlah temuan per kategori A01–A10.
3. Saat praktikum: kerjakan satu baris = uji satu modul SIMPEG terhadap satu CWE, lalu isi kolom **Status**, **Severity**, dan **Tester Notes** sesuai hasil pengujian nyata (bukan disalin dari kolom deskripsi).

## 10. Alur kerja praktikum (ringkas)

Untuk tiap sesi kelas:

1. Pilih 1 kategori OWASP (mis. A05 – Injection) dari `Category Summary`.
2. Bangun/aktifkan modul SIMPEG terkait (mis. Login untuk SQL Injection) dengan kode rentan sesuai kolom **Example 2** di checklist.
3. Uji secara manual di browser mengikuti skenario di kolom **Example 3 — Skenario Eksploitasi**.
4. Catat hasilnya di kolom **Status**/**Severity**/**Tester Notes**.
5. Terapkan perbaikan dari kolom **Prevention — Langkah Patching**, lalu uji ulang untuk membuktikan celah tertutup.

## 11. Ringkasan verifikasi "proyek berhasil diinisialisasi"

Centang semua ini sebelum lanjut ke pembuatan modul:

- [ ] Laragon **Start All** menyala hijau (Apache + MySQL).
- [ ] Document Root Laragon mengarah ke `simpeg/public/` (bukan `simpeg/`).
- [ ] `http://simpeg.test/assets/vendor/adminlte/index.html` menampilkan dashboard AdminLTE.
- [ ] Database `simpeg` sudah dibuat dan terlihat di phpMyAdmin/HeidiSQL.
- [ ] `.env` sudah disalin dari `.env.example` dan `composer install` berhasil dijalankan.
- [ ] `OWASP_Top10_2025.xlsx` sudah dibuka dan dipahami strukturnya (3 sheet).

## 12. Langkah selanjutnya

Proyek dasar sudah siap. Tahap berikutnya (di sesi terpisah, per kategori OWASP) adalah membangun modul-modul SIMPEG satu per satu — Login, Data Karyawan, Slip Gaji, Pengajuan Cuti, Absensi, Upload Dokumen, Backup, API — masing-masing disuntik kerentanan sesuai baris checklist yang relevan, lengkap dengan versi "sebelum" (rentan) dan "sesudah" (sudah dipatch) untuk keperluan demonstrasi.
