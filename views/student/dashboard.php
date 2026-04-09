<section class="hero-panel p-4 p-lg-5 rounded-4 mb-4 shadow-sm">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <span class="badge rounded-pill text-bg-light mb-3">Student Dashboard</span>
            <h1 class="display-6 fw-bold mb-2">Hello, <?= e($dashboard['student']['name'] ?? 'Student') ?></h1>
            <p class="lead mb-0 text-white-50">Track your current course load, stay within the unit limit, and manage your registration in one place.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="unit-badge d-inline-flex align-items-center">
                <span class="me-2">Current Units</span>
                <strong id="current-units"><?= e((string) $dashboard['currentUnits']) ?></strong>
                <span class="ms-1">/ <?= MAX_CREDIT_UNITS ?></span>
            </div>
        </div>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card portal-card h-100 border-0 shadow-sm">
            <div class="card-body">
                <p class="text-uppercase text-secondary small mb-2">Registered Courses</p>
                <h2 class="display-6 fw-bold mb-0" id="registered-count"><?= e((string) $dashboard['registeredCourses']) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card portal-card h-100 border-0 shadow-sm">
            <div class="card-body">
                <p class="text-uppercase text-secondary small mb-2">Available Courses</p>
                <h2 class="display-6 fw-bold mb-0"><?= e((string) $dashboard['availableCourses']) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card portal-card h-100 border-0 shadow-sm">
            <div class="card-body">
                <p class="text-uppercase text-secondary small mb-2">Remaining Units</p>
                <h2 class="display-6 fw-bold mb-0"><?= e((string) (MAX_CREDIT_UNITS - $dashboard['currentUnits'])) ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h4 mb-1">Registered Courses</h2>
                <p class="text-secondary mb-0">Quick overview of the courses currently attached to your account.</p>
            </div>
            <a href="student_courses.php" class="btn btn-primary">Manage Courses</a>
        </div>
    </div>
    <div class="card-body p-4">
        <?php if (empty($dashboard['courses'])): ?>
            <div class="empty-state text-center py-5">
                <h3 class="h5">No courses registered yet</h3>
                <p class="text-secondary">Visit the course page to begin registering for courses.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Unit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dashboard['courses'] as $course): ?>
                        <tr>
                            <td><span class="badge text-bg-primary-subtle text-primary-emphasis"><?= e($course['course_code']) ?></span></td>
                            <td><?= e($course['course_name']) ?></td>
                            <td><?= e((string) $course['unit']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
