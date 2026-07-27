<?php
/** View pencarian pegawai. Variabel dari KaryawanController::cari(): $keyword, $errorMessage, $rows. */
?>
<h3>Pencarian Pegawai</h3>
<form method="get" class="row g-2 mb-3">
    <div class="col-auto">
        <input type="text" name="q" class="form-control" placeholder="Nama pegawai" value="<?= htmlspecialchars($keyword) ?>">
    </div>
    <div class="col-auto"><button class="btn btn-primary">Cari</button></div>
</form>

<?php if ($errorMessage): ?>
    <div class="alert alert-danger">Query error: <?= $errorMessage ?></div>
<?php endif; ?>

<table class="table table-bordered bg-white">
    <thead><tr><th>NIK</th><th>Nama</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['nik']) ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td>
                <a href="/karyawan/detail.php?id=<?= (int) $row['id'] ?>">Detail</a>
                &middot;
                <a href="/karyawan/hapus.php?id=<?= (int) $row['id'] ?>" class="text-danger" onclick="return confirm('Hapus pegawai ini?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
