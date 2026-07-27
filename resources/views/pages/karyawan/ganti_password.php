<?php
/** View ganti kata sandi. Variabel dari KaryawanController::gantiPassword(): $message. */
?>
<h3>Ganti Kata Sandi</h3>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<form method="post" class="card card-body bg-white" style="max-width:420px">
    <div class="mb-3">
        <label>Kata sandi baru</label>
        <input type="password" name="password_baru" class="form-control" required>
    </div>
    <button class="btn btn-primary">Simpan</button>
</form>
