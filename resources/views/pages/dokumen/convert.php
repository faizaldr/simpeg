<?php
/** View konversi dokumen. Variabel dari DokumenController::convert(): $output. */
?>
<h3>Konversi Dokumen Kontrak ke PDF</h3>
<form method="post" enctype="multipart/form-data" class="card card-body bg-white mb-3" style="max-width:480px">
    <div class="mb-3">
        <label>Berkas kontrak (DOCX)</label>
        <input type="file" name="dok" class="form-control" required>
    </div>
    <button class="btn btn-primary">Konversi</button>
</form>
<?php if ($output !== null): ?>
    <pre class="bg-white p-3 border"><?= htmlspecialchars($output) ?></pre>
<?php endif; ?>
