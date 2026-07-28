<?php
/** View ubah rekening. Variabel dari PayrollController::updateRekening(): $message. */
?>
<h3>Ubah Rekening Gaji</h3>
<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<!-- CWE-352: form AdminLTE biasa, tanpa input token CSRF apa pun -->
<form method="post" class="card card-body bg-white" style="max-width:420px">
    <div class="mb-3">
        <?= Csrf::field()?>
        <label>Nomor rekening baru</label>
        <input type="text" name="no_rekening" class="form-control" required>
    </div>
    <button class="btn btn-primary">Simpan</button>
</form>
