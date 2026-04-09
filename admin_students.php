<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/models/Student.php';

require_admin_auth();

$students = Student::getAllWithRegistrationCount();
$pageTitle = 'All Students';

require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/admin/students.php';
require __DIR__ . '/views/partials/footer.php';
