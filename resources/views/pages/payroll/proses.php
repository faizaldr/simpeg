<?php
/** View proses payroll. Variabel dari PayrollController::proses(): $message. */
?>
<h3>Proses Payroll Bulanan</h3>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if (Auth::currentRole() === 'hrd'): ?>
<form method="post">
    <button class="btn btn-primary">Proses Payroll Bulan Ini</button>
</form>
<?php endif; ?>
