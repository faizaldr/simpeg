<?php
/** View login SSO. Variabel dari AuthController::ssoLogin(): $error. */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login SSO - SIMPEG</title>
    <link rel="stylesheet" href="/assets/vendor/adminlte/css/adminlte.css">
</head>
<body class="login-page bg-body-secondary">
<div class="login-box">
    <div class="card card-outline card-warning mt-5">
        <div class="card-header text-center"><h3>SIMPEG SSO</h3></div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/auth/sso_login.php" method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username kantor pusat (uid)" required>
                    <input type="text" name="password" class="form-control" placeholder="password" required>

                </div>
                <button type="submit" class="btn btn-warning w-100">Masuk lewat SSO</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
