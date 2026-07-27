<?php
/** View ajukan cuti. Variabel dari CutiController::ajukan(): $message. */
?>
<h3>Ajukan Cuti</h3>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<form method="post" class="card card-body bg-white" style="max-width:480px">
    <div class="mb-3">
        <label>Jumlah hari</label>
        <input type="number" name="jumlah_hari" min="1" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Catatan</label>
        <textarea name="catatan" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Ajukan</button>
</form>
