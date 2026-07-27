<?php
/** View rumus tunjangan. Variabel dari SettingsController::rumusTunjangan(): $rumusTersimpan, $hasil. */
?>
<h3>Pengaturan Rumus Tunjangan</h3>
<p class="text-muted">Variabel yang tersedia dalam rumus: <code>$masa_kerja</code> (contoh: <code>2000000 + ($masa_kerja * 50000)</code>)</p>
<form method="post" class="card card-body bg-white mb-3" style="max-width:560px">
    <div class="mb-3">
        <label>Rumus tunjangan (PHP expression)</label>
        <textarea name="rumus" class="form-control" rows="3"><?= htmlspecialchars($rumusTersimpan) ?></textarea>
    </div>
    <button class="btn btn-primary">Simpan &amp; Hitung Contoh</button>
</form>
<?php if ($hasil !== null): ?>
    <div class="alert alert-info">Hasil contoh perhitungan: <?= htmlspecialchars((string) $hasil) ?></div>
<?php endif; ?>
