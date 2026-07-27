<?php
/** View ekspor laporan. Variabel dari LaporanController::ekspor(): $rows. */
?>
<h3>Ekspor Laporan Rekap Pegawai</h3>
<p>Total data: <?= count($rows) ?> pegawai.</p>
<a href="/laporan/ekspor.php?unduh=1" class="btn btn-primary">Unduh CSV</a>
