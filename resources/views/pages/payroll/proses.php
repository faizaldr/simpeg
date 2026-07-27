<?php
/** View proses payroll. Variabel dari PayrollController::proses(): $message. */
?>
<h3>Proses Payroll Bulanan</h3>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if (Auth::currentRole() === 'hrd'): ?>
<form method="post" class="mb-4">
    <button class="btn btn-primary">Proses Payroll Bulan Ini</button>
</form>
<?php endif; ?>

<div class="d-flex flex-wrap gap-2">
    <a href="/payroll/update_rekening.php" class="btn btn-outline-secondary btn-sm">Ubah Rekening Gaji</a>
    <a href="/payroll/download.php?file=slip_202401.pdf" class="btn btn-outline-secondary btn-sm">Unduh Slip Gaji (contoh)</a>
    <?php if (Auth::currentRole() === 'hrd'): ?>
    <a href="/payroll/kirim_ke_bank.php" class="btn btn-outline-secondary btn-sm">Kirim Rekap ke Bank</a>
    <?php endif; ?>
</div>
