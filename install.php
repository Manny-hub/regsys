<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/models/Admin.php';
require_once __DIR__ . '/models/ActivityLog.php';

$created = false;
$message = '';

try {
    if (Admin::countAll() === 0) {
        $pdo = Database::getConnection();
        // Create a default admin only during first-time setup.
        $statement = $pdo->prepare('INSERT INTO admins (username, password) VALUES (:username, :password)');
        $statement->execute([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);

        $created = true;
        $message = 'Default admin created successfully. Username: admin | Password: admin123';
    } else {
        $message = 'Admin account already exists. No new admin was created.';
    }
} catch (Throwable $exception) {
    $message = 'Installation failed: ' . $exception->getMessage();
}

$pageTitle = 'Portal Installer';
require __DIR__ . '/views/partials/header.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 mb-3">Initial Admin Setup</h1>
                <div class="alert alert-<?= $created ? 'success' : 'info' ?> mb-4"><?= e($message) ?></div>
                <ol class="text-secondary mb-4">
                    <li>Import <code>database/schema.sql</code> into MySQL.</li>
                    <li>Update <code>config/database.php</code> if your MySQL credentials differ.</li>
                    <li>Use the default admin login above, then change credentials directly in the database if needed.</li>
                </ol>
                <a href="admin_login.php" class="btn btn-dark">Go to Admin Login</a>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/views/partials/footer.php'; ?>
