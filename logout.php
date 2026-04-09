<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/models/ActivityLog.php';

if (is_student_logged_in()) {
    ActivityLog::record('student', current_student_id(), 'student_logout', ($_SESSION['student_name'] ?? 'Student') . ' logged out.');
}

if (is_admin_logged_in()) {
    ActivityLog::record('admin', current_admin_id(), 'admin_logout', ($_SESSION['admin_username'] ?? 'Admin') . ' logged out.');
}

session_unset();
session_destroy();

session_start();
set_flash('success', 'You have been logged out successfully.');

redirect('index.php');
