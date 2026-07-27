<?php
/** View preferensi dashboard. Variabel dari DashboardController::preferensi(): $preferensi. */
?>
<h3>Preferensi Dashboard</h3>
<p>Tema aktif saat ini: <strong><?= htmlspecialchars($preferensi->tema ?? '-') ?></strong></p>
<form method="post" class="card card-body bg-white" style="max-width:420px">
    <div class="mb-3">
        <label>Tema</label>
        <select name="tema" class="form-select">
            <option value="terang">Terang</option>
            <option value="gelap">Gelap</option>
        </select>
    </div>
    <button class="btn btn-primary">Simpan Preferensi</button>
</form>
