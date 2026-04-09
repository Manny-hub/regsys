<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/controllers/AuthController.php';

if (is_student_logged_in()) {
    redirect('student_dashboard.php');
}

if (is_post_request()) {
    validate_csrf_or_fail($_POST['csrf_token'] ?? null);
    store_old_input($_POST);
    $result = AuthController::loginStudent($_POST);

    if ($result['success']) {
        clear_old_input();
        set_flash('success', 'Welcome back, ' . ($_SESSION['student_name'] ?? 'Student') . '.');
        redirect('student_dashboard.php');
    }

    set_flash('danger', $result['message']);
}

$pageTitle = 'Student Login';
require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/auth/student_login_form.php';
require __DIR__ . '/views/partials/footer.php';
