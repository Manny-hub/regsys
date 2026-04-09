<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/controllers/AuthController.php';

if (is_admin_logged_in()) {
    redirect('admin_dashboard.php');
}

if (is_post_request()) {
    validate_csrf_or_fail($_POST['csrf_token'] ?? null);
    store_old_input($_POST);
    $result = AuthController::loginAdmin($_POST);

    if ($result['success']) {
        clear_old_input();
        set_flash('success', 'Administrator login successful.');
        redirect('admin_dashboard.php');
    }

    set_flash('danger', $result['message']);
}

$pageTitle = 'Admin Login';
require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/auth/admin_login_form.php';
require __DIR__ . '/views/partials/footer.php';
