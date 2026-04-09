<?php

require_once __DIR__ . '/config/app.php';

if (is_student_logged_in()) {
    redirect('student_dashboard.php');
}

if (is_admin_logged_in()) {
    redirect('admin_dashboard.php');
}

$pageTitle = APP_NAME;
$bodyClass = 'home-page';

require __DIR__ . '/views/partials/header.php';
?>
<section class="hero-panel p-4 p-lg-5 rounded-4 shadow-sm">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <span class="badge rounded-pill text-bg-warning mb-3">ESAE Bénin University</span>
            <h1 class="display-5 fw-bold mb-3">Online Course Registration Portal</h1>
            <p class="lead text-white-50 mb-4">A complete web-based system for student course registration, course management, and administrative monitoring.</p>
            <div class="d-flex flex-wrap gap-3">
                <a href="student_register.php" class="btn btn-warning btn-lg">Create Student Account</a>
                <a href="student_login.php" class="btn btn-outline-light btn-lg">Student Login</a>
                <a href="admin_login.php" class="btn btn-light btn-lg">Admin Login</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">Core Features</h2>
                    <ul class="mb-0 text-secondary">
                        <li>Secure student and admin authentication</li>
                        <li>Online course registration and dropping</li>
                        <li>Credit unit limit enforcement</li>
                        <li>Course search, filtering, and pagination</li>
                        <li>Admin statistics and activity logging</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/views/partials/footer.php'; ?>
