<?php
/** View upload dokumen. Variabel dari DokumenController::upload(): $message. */
?>
<h3>Upload Dokumen Kepegawaian</h3>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data" class="card card-body bg-white" style="max-width:480px">
    <div class="mb-3">
        <label>Jenis dokumen</label>
        <select name="jenis" class="form-select">
            <option value="ktp">KTP</option>
            <option value="ijazah">Ijazah</option>
            <option value="kontrak">Kontrak</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Berkas</label>
        <input type="file" name="dokumen" class="form-control" required>
    </div>
    <button class="btn btn-primary">Unggah</button>
</form>
