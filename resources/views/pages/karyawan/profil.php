<?php
/** View profil. Variabel dari KaryawanController::profil(): $message, $karyawan. */
?>
<h3>Profil Saya</h3>
<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<form method="post" class="card card-body bg-white" style="max-width:480px">
    <!-- CWE-639: hidden input id_karyawan bisa diubah lewat DevTools -->
    <input type="hidden" name="id_karyawan" value="<?= (int) $karyawan['id'] ?>">
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($karyawan['nama']) ?>">
    </div>
    <button class="btn btn-primary">Simpan</button>
</form>
