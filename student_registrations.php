<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/models/Registration.php';

require_student_auth();

$studentId = current_student_id();
$registeredCourses = Registration::getStudentCourses($studentId);
$currentUnits = Registration::getStudentTotalUnits($studentId);
$pageTitle = 'My Registrations';

require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/student/registrations.php';
require __DIR__ . '/views/partials/footer.php';
