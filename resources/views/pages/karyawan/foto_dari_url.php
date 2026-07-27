<?php
/** View ambil foto dari URL. Variabel dari KaryawanController::fotoDariUrl(): $message. */
?>
<h3>Ambil Foto Profil dari URL</h3>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<form method="post" class="card card-body bg-white" style="max-width:480px">
    <div class="mb-3">
        <label>URL foto</label>
        <input type="text" name="url_foto" class="form-control" placeholder="https://..." required>
    </div>
    <button class="btn btn-primary">Ambil &amp; Simpan</button>
</form>
