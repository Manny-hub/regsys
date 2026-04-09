<?php
$currentScript = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark portal-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="index.php">ESAE Course Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#portalNavbar" aria-controls="portalNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="portalNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <?php if (is_student_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'student_dashboard.php' ? 'active' : '' ?>" href="student_dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'student_courses.php' ? 'active' : '' ?>" href="student_courses.php">Courses</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'student_registrations.php' ? 'active' : '' ?>" href="student_registrations.php">My Registrations</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm px-3" href="logout.php">Logout</a></li>
                <?php elseif (is_admin_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'admin_dashboard.php' ? 'active' : '' ?>" href="admin_dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'admin_courses.php' ? 'active' : '' ?>" href="admin_courses.php">Manage Courses</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'admin_students.php' ? 'active' : '' ?>" href="admin_students.php">Students</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'admin_registrations.php' ? 'active' : '' ?>" href="admin_registrations.php">Registrations</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm px-3" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'student_login.php' ? 'active' : '' ?>" href="student_login.php">Student Login</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentScript === 'student_register.php' ? 'active' : '' ?>" href="student_register.php">Student Register</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm px-3" href="admin_login.php">Admin Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
