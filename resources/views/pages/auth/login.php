<?php
/**
 * View login. Variabel dari AuthController::login(): $error, $httpHost.
 * CWE-319 Cleartext Transmission: skema form dipaksa http:// (bukan https://).
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Masuk - SIMPEG</title>
    <link rel="stylesheet" href="/assets/vendor/adminlte/css/adminlte.css">
</head>
<body class="login-page bg-body-secondary">
<div class="login-box">
    <div class="card card-outline card-primary mt-5">
        <div class="card-header text-center"><h3>SIMPEG</h3></div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="http://<?= htmlspecialchars($httpHost) ?>/auth/login.php" method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Kata sandi" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="ingat_saya" value="1" class="form-check-input" id="ingat">
                    <label class="form-check-label" for="ingat">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
            <p class="mt-3"><a href="/auth/sso_login.php">Masuk lewat SSO kantor pusat</a></p>
        </div>
    </div>
</div>
</body>
</html>
