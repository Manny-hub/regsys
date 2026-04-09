<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/StudentController.php';

require_student_auth();

if (!is_post_request()) {
    json_response(['success' => false, 'message' => 'Invalid request method.'], 405);
}

// Accept JSON for AJAX requests and regular POST data as a fallback.
$payload = json_decode(file_get_contents('php://input'), true);
$token = $payload['csrf_token'] ?? $_POST['csrf_token'] ?? null;

if (!verify_csrf_token($token)) {
    json_response(['success' => false, 'message' => 'Invalid request token.'], 419);
}

$action = $payload['action'] ?? $_POST['action'] ?? '';
$courseId = isset($payload['course_id']) ? (int) $payload['course_id'] : (int) ($_POST['course_id'] ?? 0);

if ($courseId <= 0) {
    json_response(['success' => false, 'message' => 'Invalid course selected.'], 422);
}

$studentId = current_student_id();
$result = $action === 'drop'
    ? StudentController::dropCourse($studentId, $courseId)
    : StudentController::registerCourse($studentId, $courseId);

json_response($result, $result['success'] ? 200 : 422);
