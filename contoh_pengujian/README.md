# Berkas Contoh Pengujian

Folder ini berisi berkas siap pakai untuk membuktikan beberapa CWE di `langkah_pengujian_kerentanan_dan_patching.md`, supaya peserta tinggal memilihnya lewat form upload di browser (tanpa perlu membuat berkas sendiri).

- **`cwe434_bukti.jpg`** — dipakai pada §6 CWE-434 (Unrestricted File Upload). Isinya kode PHP, bukan gambar sungguhan, tapi lolos validasi karena ekstensinya `.jpg`.
- **`cwe248_tanggal_invalid.xml`** — dipakai pada §7 CWE-248 (Uncaught Exception). XML-nya valid secara sintaks, tapi kolom `<tanggal>` berisi teks bukan tanggal, sehingga memicu error database yang tidak tertangani.

Berkas-berkas ini **bukan** bagian dari aplikasi SIMPEG — hanya alat bantu demo kelas, aman dihapus setelah pelatihan selesai.
