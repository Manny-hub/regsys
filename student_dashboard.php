<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/controllers/StudentController.php';

require_student_auth();

$dashboard = StudentController::getDashboardData(current_student_id());
$pageTitle = 'Student Dashboard';

require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/student/dashboard.php';
require __DIR__ . '/views/partials/footer.php';
