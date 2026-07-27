<?php
/** View daftar cuti. Variabel dari CutiController::daftar(): $rows. */
?>
<h3>Daftar Pengajuan Cuti</h3>
<table class="table table-bordered bg-white">
    <thead><tr><th>Pegawai</th><th>Tanggal</th><th>Status</th><th>Catatan</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['tanggal_mulai']) ?> s/d <?= htmlspecialchars($row['tanggal_selesai']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <!-- CWE-79: TIDAK di-escape, langsung dicetak sebagai HTML -->
            <td><?= $row['catatan'] ?></td>
            <td><a href="/cuti/setujui.php?id=<?= (int) $row['id'] ?>">Setujui</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
