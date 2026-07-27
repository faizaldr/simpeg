<?php
/** View import absensi. Variabel dari AbsensiController::import(): $hasil, $previewXxe. */
?>
<h3>Import Absensi (XML)</h3>
<form method="post" enctype="multipart/form-data" class="card card-body bg-white mb-3" style="max-width:480px">
    <div class="mb-3">
        <label>Berkas XML mesin fingerprint</label>
        <input type="file" name="berkas_xml" class="form-control" required>
    </div>
    <button class="btn btn-primary">Import</button>
</form>
<?php if ($hasil): ?>
    <div class="alert alert-info"><?= htmlspecialchars($hasil) ?></div>
    <pre class="bg-white p-3 border"><?= htmlspecialchars($previewXxe ?? '') ?></pre>
<?php endif; ?>
