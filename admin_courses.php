<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/models/Course.php';

require_admin_auth();

$adminId = current_admin_id();

if (is_post_request()) {
    validate_csrf_or_fail($_POST['csrf_token'] ?? null);

    if (isset($_POST['save_course'])) {
        $result = AdminController::saveCourse($_POST, $adminId, !empty($_POST['course_id']) ? (int) $_POST['course_id'] : null);
        set_flash($result['success'] ? 'success' : 'danger', $result['message']);
        redirect('admin_courses.php');
    }

    if (!empty($_POST['delete_course_id'])) {
        $result = AdminController::deleteCourse((int) $_POST['delete_course_id'], $adminId);
        set_flash($result['success'] ? 'success' : 'danger', $result['message']);
        redirect('admin_courses.php');
    }
}

$search = trim($_GET['search'] ?? '');
$page = current_page();
$perPage = 8;
$totalCourses = Course::countAll($search);
$totalPages = max((int) ceil($totalCourses / $perPage), 1);
$page = min($page, $totalPages);
$courses = Course::getPaginated($search, $perPage, paginate_offset($page, $perPage));
$editingCourse = !empty($_GET['edit']) ? Course::findById((int) $_GET['edit']) : null;

$formData = [
    'course_name' => $editingCourse['course_name'] ?? '',
    'course_code' => $editingCourse['course_code'] ?? '',
    'unit' => $editingCourse['unit'] ?? '',
];

$pageTitle = 'Manage Courses';

require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/admin/courses.php';
require __DIR__ . '/views/partials/footer.php';
