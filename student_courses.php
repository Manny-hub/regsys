<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/controllers/StudentController.php';

require_student_auth();

$search = trim($_GET['search'] ?? '');
$page = current_page();
$courseData = StudentController::getCoursePageData(current_student_id(), $search, $page, 6);
$pageTitle = 'Course Directory';

require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/student/courses.php';
require __DIR__ . '/views/partials/footer.php';
