<?php
/** View detail pegawai. Variabel dari KaryawanController::detail(): $data (bisa null, lihat CWE-476). */
?>
<h3>Detail Pegawai</h3>
<table class="table bg-white">
    <tr><th>Nama</th><td><?= htmlspecialchars($data->nama) ?></td></tr>
    <tr><th>NIK</th><td><?= htmlspecialchars($data->nik) ?></td></tr>
    <tr><th>Atasan Langsung (id)</th><td><?= htmlspecialchars((string) $data->id_atasan) ?></td></tr>
</table>
